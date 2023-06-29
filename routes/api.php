<?php

use App\Http\Controllers\v1\PostController;
use App\Http\Controllers\v1\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// fetch posts and comments from the api
Route::get('/get-posts-and-comments', [PostController::class,'fetch']);

// gets list of top posts with comment counts
Route::get('/posts', [PostController::class,'index']);

// filter comments based on available fields
Route::post('/posts/{id}/search',[SearchController::class,'store']);

