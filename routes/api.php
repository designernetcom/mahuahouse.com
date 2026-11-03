<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContentController;

Route::get('/hero',          [ContentController::class, 'hero']);
Route::get('/stats',         [ContentController::class, 'stats']);
Route::get('/why-choose',    [ContentController::class, 'whyChoose']);
Route::get('/experiences',   [ContentController::class, 'experiences']);
Route::get('/rooms',         [ContentController::class, 'rooms']);
Route::get('/rooms/{id}',    [ContentController::class, 'room']);
Route::get('/gallery',       [ContentController::class, 'gallery']);
Route::get('/testimonials',  [ContentController::class, 'testimonials']);
Route::get('/team',          [ContentController::class, 'team']);
Route::get('/blog',          [ContentController::class, 'blog']);
Route::get('/blog/{slug}',   [ContentController::class, 'blogPost']);
Route::get('/offers',        [ContentController::class, 'offers']);
Route::get('/faq',           [ContentController::class, 'faq']);
Route::get('/contact-info',  [ContentController::class, 'contactInfo']);
Route::get('/settings',      [ContentController::class, 'settings']);
Route::get('/about',         [ContentController::class, 'about']);
Route::post('/inquiries',    [ContentController::class, 'submitInquiry']);
