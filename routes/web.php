<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::any('{any}', function () {
    $desiredResponseCode = intval(request()->input('response_code', 200));
    $message             = sprintf(
        '%s: %s',
        $desiredResponseCode,
        data_get(Response::$statusTexts, $desiredResponseCode)
    );

    return response()->json([
        'data'    => request()->all(),
        'headers' => collect(request()->headers),
        'message' => $message,
        'method'  => request()->method(),
        'status'  => $desiredResponseCode,
        'url'     => request()->fullUrl(),
    ], $desiredResponseCode);
})->where('any', '.*');
