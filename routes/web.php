<?php

use App\Models\Feed;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $feeds = Feed::with(['changedBy', 'fedBy', 'skinToSkinWith', 'timeInSunWith'])
        ->latest()
        ->get();

    return view('welcome', ['feeds' => $feeds]);
});
