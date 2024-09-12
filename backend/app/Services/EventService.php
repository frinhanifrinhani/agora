<?php

namespace App\Services;

use App\Helpers\MakeAlias;
use App\Constants\Entities;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\EventRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class EventService
{
    use MakeAlias;
    use DateHelper;

    private EventRepository $eventRepository;
    protected $request;

    public function __construct(EventRepository $eventRepository, Request $request)
    {
        $this->eventRepository = $eventRepository;
        $this->request = $request;
    }

    public function getAllEvents($request)
    {
        return $this->eventRepository->paginate($request->limit, $request->page);
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

}