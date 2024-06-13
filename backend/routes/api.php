<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('user', UserController::class);
    Route::prefix('user')->group(function () {
        Route::get('/user-paginate', [NewsController::class, 'index']);
    });
});

Route::controller(NewsController::class)->group(function () {
    Route::get('/news', 'index');
    Route::get('/news/{id}', 'show');
    Route::middleware('auth:sanctum')->post('/news', 'store');
    Route::middleware('auth:sanctum')->put('/news/{id}', 'update');
    Route::middleware('auth:sanctum')->delete('/news/{id}', 'destroy');
});


Route::match(['post', 'patch', 'put', 'delete'], '{any}', function (Request $request) {
    return response()->json(['message' => 'Method not allowed.'], 405);
})->where('any', '.*');
