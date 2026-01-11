<?php

use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\PostTagController;
use App\Http\Controllers\Api\V1\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::apiResource('posts', PostController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('tags', TagController::class);

    // Post-Tag relationships
    Route::prefix('posts/{post}/tags')->group(function () {
        Route::get('/', [PostTagController::class, 'index']);
        Route::post('/attach', [PostTagController::class, 'attach']);
        Route::post('/detach', [PostTagController::class, 'detach']);
        Route::post('/sync', [PostTagController::class, 'sync']);
    });

});
