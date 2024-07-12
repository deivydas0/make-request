<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::any('{any}', function (Request $request) {
    $desiredResponseCode = intval($request->input('response_code', 200));
    $message             = sprintf(
        '%s: %s',
        $desiredResponseCode,
        data_get(Response::$statusTexts, $desiredResponseCode)
    );

    $responseData = [
        'data'    => $request->all(),
        'headers' => collect($request->headers),
        'message' => $message,
        'method'  => $request->method(),
        'status'  => $desiredResponseCode,
        'url'     => $request->fullUrl(),
    ];

    // info($responseData);

    return response()->json($responseData, $desiredResponseCode);
})->where('any', '.*');
