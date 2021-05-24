<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\TopicController;

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

Route::post('topics', [TopicController::class, 'store']);
Route::post('subscribe/{topic:reference}', [SubscriberController::class, 'subscribe']);
Route::post('publish/{topic:reference}', [TopicController::class, 'publish']);
