<?php

use Illuminate\Support\Facades\Route;

Route::any('{any}', function () {
    return response()->json([
        'headers' => collect(request()->headers),
        'body'    => request()->all(),
    ]);
})->where('any', '.*');
