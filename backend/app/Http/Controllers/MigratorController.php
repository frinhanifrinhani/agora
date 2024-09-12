<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Services\NewsService;
use App\Services\MigratorService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\NewsRequest;
use Illuminate\Support\Facades\Storage;

class MigratorController extends Controller
{

    private MigratorService $migratorService;

    public function __construct(MigratorService $migratorService)
    {
        $this->migratorService = $migratorService;
    }

    public function news()
    {
        return $this->migratorService->migrateNews();
    }

    public function event()
    {
        return $this->migratorService->migrateEvents();
    }

    public function filesNews()
    {
        return $this->migratorService->migrateFilesNews();
    }
    
    public function filesEvents()
    {
        return $this->migratorService->migrateFilesEvents();
    }
}