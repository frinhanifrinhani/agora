<?php

use App\Http\Controllers\NoticiaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/check-db-connection', function () {
    try {
        DB::connection()->getPdo();
        return response()->json(['message' => 'Conectado no banco!'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Não foi possivel conectar no banco', 'error' => $e->getMessage()], 500);
    }
});

Route::resource('noticia', NoticiaController::class);
Route::prefix('noticia')->group(function () {
    Route::get('/noticia-paginate', [NoticiaController::class, 'index']);
});
