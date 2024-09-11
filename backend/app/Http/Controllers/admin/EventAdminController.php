<?php

namespace App\Http\Controllers\admin;


use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\EventRequest;
use App\Http\Controllers\Controller;
use App\Services\admin\EventAdminService;

class EventAdminController extends Controller
{
    private EventAdminService $eventService;

    public function __construct(EventAdminService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request)
    {
        return $this->eventService->getAllEvents($request);
    }

    public function store(EventRequest $request)
    {
        return $this->eventService->createEvents($request);
    }

    public function show(string $id): JsonResponse
    {
        return $this->eventService->getEventsById($id);
    }

    public function update(EventRequest $request, int $id): JsonResponse
    {
        return $this->eventService->updateEvents($request, $id);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->eventService->deleteEvents($id);
    }
}
