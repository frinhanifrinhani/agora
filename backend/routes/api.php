<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MigratorController;
use App\Http\Controllers\CommentController;

Route::get('/check-db-connection', function () {
    try {
        DB::connection()->getPdo();
        return response()->json(['message' => 'Conectado no banco!'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Não foi possivel conectar no banco', 'error' => $e->getMessage()], 500);
    }
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::middleware('auth:sanctum')->post('/logout', 'logout');
});

Route::controller(FileController::class)->group(function () {
    //return all
    Route::get('/images', 'images');
    Route::get('/files', 'files');
    //get by id
    Route::get('/images/{id}', 'show');
    Route::get('/files/{id}', 'show');
    //create
    Route::middleware('auth:sanctum')->post('/images', 'creteImage');
    Route::middleware('auth:sanctum')->post('/files', 'creteFile');
    // delete
    Route::middleware('auth:sanctum')->delete('/files/{id}', 'destroy');
});

Route::controller(NewsController::class)->group(function () {
    Route::get('/news', 'index');
    //Route::get('/news/{id}', 'show'); //alterar para dashboard/news/
    Route::get('/news/{alias}', 'newsByAlias');
    Route::middleware('auth:sanctum')->post('/news', 'store');
    Route::middleware('auth:sanctum')->put('/news/{id}', 'update');
    Route::middleware('auth:sanctum')->delete('/news/{id}', 'destroy');
});

Route::middleware(['auth:sanctum'])->controller(CommentController::class)->group(function () {
    Route::resource('comments', CommentController::class);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('events', EventController::class);
});
Route::resource('events', EventController::class);

Route::prefix('migrator')->middleware('auth:sanctum')->controller(MigratorController::class)->group(function () {
    Route::post('news', 'news');
    Route::post('event', 'event');
    Route::post('filesNews', 'filesNews');
    Route::post('filesEvent', 'filesEvent');
});
