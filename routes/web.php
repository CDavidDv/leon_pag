<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Route;

// NO AUTH ROUTES 
Route::get('/', [DashboardController::class, 'index'])->name("index");
Route::get('/edit', [DashboardController::class, 'edit'])->name("edit");
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name("dashboard");
Route::get('/dashboard/edit', [DashboardController::class, 'dashboardEdit'])->name("dashboardEdit");
Route::get('/work', [DashboardController::class, 'work'])->name("work");
Route::get('/work/edit', [DashboardController::class, 'workEdit'])->name("workEdit");
Route::get('/approach', [DashboardController::class, 'approach'])->name("approach");
Route::get('/approach/edit', [DashboardController::class, 'approachEdit'])->name("approachEdit");
Route::get('/about', [DashboardController::class, 'about'])->name("about");   
Route::get('/about/edit', [DashboardController::class, 'aboutEdit'])->name("aboutEdit");
Route::get('/api/upload/video', [DashboardController::class, 'uploadVideo'])->name("uploadVideo");

// Media routes
Route::post('/api/media/upload', [MediaController::class, 'uploadImage'])->name('media.upload');
Route::delete('/api/media/delete', [MediaController::class, 'deleteImage'])->name('media.delete');
Route::get('/api/media/{section}', [MediaController::class, 'getSectionImages'])->name('media.getSection');