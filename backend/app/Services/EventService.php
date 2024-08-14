<?php

namespace App\Services;

use App\Helpers\MakeAlias;
use App\Constants\Entities;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\EventRepository;
use App\Repositories\EventScheduleRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class EventService
{
    use MakeAlias;
    use DateHelper;

    private EventRepository $eventRepository;
    private EventScheduleService $eventScheduleService;
    protected $request;

    public function __construct(EventRepository $eventRepository, EventScheduleService $eventScheduleService, Request $request)
    {
        $this->eventRepository = $eventRepository;
        $this->eventScheduleService = $eventScheduleService;
        $this->request = $request;
    }

    public function getAllEvents($request)
    {
        return $this->eventRepository->paginate($request->limit, $request->page);
    }

    public function createEvents($request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $eventsData = $this->handlerEvent($request);

            $eventsResponse = $this->eventRepository->create($eventsData);
            if ($request->has("schedule")) {
                $this->eventScheduleService->createEventSchedule($request->validated(['schedule']), $eventsResponse->id);
            }

            if ($request->has("tags")) {
                $eventsResponse->tag()->sync($eventsData['tags']);
            }

            DB::commit();

            $eventsResponse = $eventsResponse->load(['eventSchedule']);

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.saved',
                            [
                                'model' => ucfirst(Entities::EVENT),
                            ]
                        )
                    ],
                    'data' => [
                        'event' => $eventsResponse
                    ]
                ],
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {

            if ($e->getCode() == 23505) {
                return response()->json(
                    [
                        'error' => [
                            'message' =>
                            __(
                                'messages.erro.duplicateError',
                                [
                                    'model' => ucfirst(Entities::EVENT),
                                ]
                            )
                        ]
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            return response()->json(
                [
                    'error' => [
                        'message' => $e->getMessage()
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function getEventsById($id)
    {
        try {
            $events = $this->eventRepository
                ->findByAttributeWhitRelation('id', $id)
                ->with('eventSchedule')
                ->with('tag')
                ->firstOrFail();

            return response()->json(
                [
                    'data' => $events
                ],
                Response::HTTP_OK
            );
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'error' => [
                        'message' =>
                        __(
                            'messages.erro.notFound',
                            [
                                'model' => ucfirst(Entities::EVENT),
                            ]
                        )
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        } catch (\Exception  $e) {
            return response()->json(
                [
                    'error' => [
                        'message' => $e->getMessage()
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function updateEvents($request, $id)
    {

        try {
            $eventsData = $this->handlerEvent($request);
            DB::beginTransaction();

            $eventsResponse = $this->eventRepository->update($eventsData, $id);

            if ($request->has('schedule')) {
                $schedule = $request->input('schedule');
                $eventsResponse->syncEventSchedule($schedule);
            }

            $eventsResponse->tag()->sync($eventsData['tags']);

            DB::commit();

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.updated',
                            [
                                'model' => ucfirst(Entities::EVENT),
                            ]
                        )
                    ],
                    'data' => [
                        'event' => $eventsResponse
                    ]
                ],
                Response::HTTP_CREATED
            );
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'error' => [
                        'message' =>
                        __(
                            'messages.erro.notFound',
                            [
                                'model' => ucfirst(Entities::EVENT),
                            ]
                        )
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        } catch (\Exception $e) {

            if ($e->getCode() == 23505) {
                return response()->json(
                    [
                        'error' => [
                            'message' =>
                            __(
                                'messages.erro.duplicateError',
                                [
                                    'model' => ucfirst(Entities::EVENT),
                                ]
                            )
                        ]
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            return response()->json(
                [
                    'error' => [
                        'message' => $e->getMessage()
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function deleteEvents($id)
    {
        try {

            $this->eventRepository->delete($id);

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.deleted',
                            [
                                'model' => ucfirst(Entities::EVENT),
                            ]
                        )
                    ]
                ],
                Response::HTTP_OK
            );
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'error' => [
                        'message' =>
                        __(
                            'messages.erro.notFound',
                            [
                                'model' => ucfirst(Entities::EVENT),
                            ]
                        )
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => [
                        'message' => $e->getMessage()
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    private function handlerEvent($request)
    {
        $eventData = $request->validated();

        if ($eventData['publicated']) {
            $eventData['publication_date'] = $this->getNow();
        }

        if (!empty($eventData['location'])) {
            $eventData['location_alias'] = $this->stringToAlias($eventData['location']);
        }

        if (!empty($eventData['venue'])) {
            $eventData['venue_alias'] = $this->stringToAlias($eventData['venue']);
        }

        $eventAlias = $this->stringToAlias($eventData['title']);

        $eventData['alias'] = $eventAlias;
        $this->request->isMethod('post') ? $eventData['user_id'] = auth()->id() : null;

        return $eventData;
    }
}
