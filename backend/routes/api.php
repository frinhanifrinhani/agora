<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MigratorController;

use App\Http\Controllers\admin\UserAdminController;
use App\Http\Controllers\admin\AuthAdminController;
use App\Http\Controllers\admin\NewsAdminController;
use App\Http\Controllers\admin\CategoryAdminController;

Route::get('/check-db-connection', function () {
    try {
        DB::connection()->getPdo();
        return response()->json(['message' => 'Conectado no banco!'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Não foi possivel conectar no banco', 'error' => $e->getMessage()], 500);
    }
});

Route::controller(AuthAdminController::class)->group(function () {
    Route::post('/login', 'login');
    Route::middleware('auth:sanctum')->post('/logout', 'logout');
});

#################################################
#                 ROTAS SITE                    #
#################################################

Route::controller(NewsController::class)->group(function () {
    Route::get('/news', 'index');
    Route::get('/news/{alias}', 'newsByAlias');
});

#################################################
#                 ROTAS ADMIN                   #
#################################################


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

Route::middleware(['auth:sanctum'])->controller(CommentController::class)->group(function () {
    Route::resource('comments', CommentController::class);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('users', UserAdminController::class);
    Route::resource('admin/categories', CategoryAdminController::class);
    Route::resource('admin/news', NewsAdminController::class);
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
