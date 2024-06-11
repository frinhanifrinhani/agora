<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\UsuarioController;

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


Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::middleware('auth:sanctum')->post('/logout', 'logout');
});

Route::resource('usuario', UsuarioController::class);
Route::prefix('usuario')->group(function () {
    Route::get('/usuarios-paginate', [UsuarioController::class, 'index']);
});

Route::resource('noticia', NoticiaController::class);
Route::prefix('noticia')->group(function () {
    Route::get('/noticia-paginate', [NoticiaController::class, 'index']);
});
