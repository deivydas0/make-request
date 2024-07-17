<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::any('{any}', function (Request $request) {
    $desiredResponseCode = intval($request->input('response_code', 200));
    $noWrap              = $request->boolean('no_wrap', true);

    $message = sprintf(
        '%s: %s',
        $desiredResponseCode,
        data_get(Response::$statusTexts, $desiredResponseCode)
    );

    $info = [
        'headers' => collect($request->headers),
        'message' => $message,
        'method'  => $request->method(),
        'status'  => $desiredResponseCode,
        'url'     => $request->fullUrl(),
    ];

    $response = [
        'request' => $info,
    ];

    $data = $noWrap ? $request->all() : ['data' => $request->all()];

    return response()->json(array_merge($response, $data), $desiredResponseCode);
})->where('any', '.*');
