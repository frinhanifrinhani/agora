<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MigratorController;

use App\Http\Controllers\admin\TagAdminController;
use App\Http\Controllers\admin\AuthAdminController;
use App\Http\Controllers\admin\NewsAdminController;
use App\Http\Controllers\admin\UserAdminController;
use App\Http\Controllers\admin\EventAdminController;
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

Route::controller(EventController::class)->group(function () {
    Route::get('/events', 'index');
    Route::get('/events/{alias}', 'eventsByAlias');
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
});

Route::middleware(['auth:sanctum'])->prefix('admin')->name('admin.')->group(function () {

    Route::controller(NewsAdminController::class)->group(function () {
        Route::resource('news', NewsAdminController::class);
        Route::put('/news/publish/{id}', 'publish');
        Route::put('/news/unpublish/{id}', 'unpublish');
    });

    Route::controller(TagAdminController::class)->group(function () {
        Route::resource('tags', TagAdminController::class);
        Route::get('/tags/choice/all', 'tagsToChoice');
    });

    Route::resource('events', EventAdminController::class);

    Route::controller(CategoryAdminController::class)->group(function () {
        Route::resource('categories', CategoryAdminController::class);
        Route::get('/categories/choice/all', 'categoriesToChoice');
        Route::put('/categories/publish/{id}', 'publish');
        Route::put('/categories/unpublish/{id}', 'unpublish');
    });
});

Route::prefix('migrator')->middleware('auth:sanctum')->controller(MigratorController::class)->group(function () {
    Route::post('news', 'news');
    Route::post('event', 'event');
    Route::post('filesNews', 'filesNews');
    Route::post('filesEvents', 'filesEvents');
});
