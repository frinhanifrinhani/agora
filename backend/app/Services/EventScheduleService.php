<?php

namespace App\Services;

use App\Helpers\MakeAlias;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\EventScheduleRepository;


class EventScheduleService
{
    use MakeAlias;
    use DateHelper;

    private EventScheduleRepository $eventRepository;
    protected $request;

    public function __construct(EventScheduleRepository $eventRepository,Request $request )
    {
        $this->eventRepository = $eventRepository;
        $this->request = $request;
    }

    public function createEventSchedule($eventScheduleData,$eventId)
    {

        foreach ($eventScheduleData as $event) {
            $event['event_id'] = $eventId;
            $this->eventRepository->create( $event);
        }

    }

    public function deleteEventSchedules($id)
    {
        try {

            $this->eventRepository->delete($id);

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.deleted',
                            [
                                'model' => 'EventSchedules'
                            ]
                        )
                    ]
                ],
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => [$e->getMessage()]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

}
