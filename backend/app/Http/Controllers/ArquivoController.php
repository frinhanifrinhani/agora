<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ArquivoRequest;
use App\Services\ArquivoService;

class ArquivoController extends Controller
{
    private ArquivoService $arquivoService;

    public function __construct(ArquivoService $arquivoService)
    {
        $this->arquivoService = $arquivoService;
    }

    public function images(ArquivoRequest $request)
    {
        return $this->arquivoService->createArquivo($request,'image');
    }

    public function files(ArquivoRequest $request)
    {
        return $this->arquivoService->createArquivo($request,'file');
    }

}
