<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkContentController;
use App\Http\Controllers\MediaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas para WorkContent
Route::get('/work-content', [WorkContentController::class, 'index']);
Route::post('/work-content/text', [WorkContentController::class, 'updateText']);
Route::post('/work-content/text-content', [WorkContentController::class, 'updateTextContent']);
Route::get('/work-content/text-content', [WorkContentController::class, 'getTextContent']);
Route::post('/work-content/image', [WorkContentController::class, 'updateImage']);
Route::post('/work-content/link', [WorkContentController::class, 'updateLink']);
Route::post('/work-content/video', [WorkContentController::class, 'updateVideo']);
Route::post('/work-content/video-url', [WorkContentController::class, 'updateVideoUrl']);
Route::post('/work-content/image-url', [WorkContentController::class, 'updateImageUrl']);
Route::post('/work-content/media', [WorkContentController::class, 'updateMedia']);

// Rutas para Media (imágenes y videos)
Route::post('/media/upload', [MediaController::class, 'uploadImage']);
Route::post('/media/upload-image', [MediaController::class, 'uploadImage']);
Route::post('/media/upload-video', [MediaController::class, 'uploadVideo']);
Route::delete('/media/{id}', [MediaController::class, 'deleteMedia']);
Route::get('/media/images/{section}', [MediaController::class, 'getSectionImages']);
Route::get('/media/videos/{section}', [MediaController::class, 'getSectionVideos']);
Route::get('/media/project/{section}', [MediaController::class, 'getProjectMedia']);
Route::get('/media/{section}', [MediaController::class, 'getSectionMedia']);
