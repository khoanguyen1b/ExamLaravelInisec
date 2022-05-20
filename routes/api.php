<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\PostController;

Route::post('/subscribe/website', [\App\Http\Controllers\SubscribeController::class, 'subscribeAWebsite']);
Route::post('/post/create', [\App\Http\Controllers\PostController::class, 'create']);
