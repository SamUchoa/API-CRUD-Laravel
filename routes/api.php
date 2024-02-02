<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

// Route::resource("/produtos", ProductController::class);

Route::get('/produtos/busca', [ProductController::class, 'search']);

Route::post('/registrar', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/produtos', [ProductController::class, 'index']);

Route::get('/produtos/{id}', [ProductController::class, 'show']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/produtos', [ProductController::class, 'store']);

    Route::put('/produtos/{id}', [ProductController::class, 'update']);

    Route::delete('/produtos/{id}', [ProductController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

// Route::middleware('auth:sanctum')->get('/produtos/busca', [ProductController::class, 'search']);





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
