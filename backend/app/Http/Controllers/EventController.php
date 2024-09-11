<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Services\EventService;

class EventController extends Controller
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request)
    {
        return $this->eventService->getAllEvents($request);
    }

    public function show(string $id): JsonResponse
    {
        return $this->eventService->getEventsById($id);
    }

}
