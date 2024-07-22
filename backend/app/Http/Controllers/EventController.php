<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Services\EventService;

class EventController extends Controller
{
    private EventService $newsService;

    public function __construct(EventService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index(Request $request)
    {
        return $this->newsService->getAllEvents($request);
    }

    public function store(EventRequest $request)
    {
        return $this->newsService->createEvents($request);
    }

    public function show(string $id): JsonResponse
    {
        return $this->newsService->getEventsById($id);
    }

    public function update(EventRequest $request, int $id): JsonResponse
    {
        return $this->newsService->updateEvents($request, $id);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->newsService->deleteEvents($id);
    }
}
