<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Vyuldashev\LaravelOpenApi\Http\OpenApiController;

Route::group(['as' => 'openapi.'], function () {
    foreach (config('openapi.collections', []) as $name => $config) {
        $uri = Arr::get($config, 'route.uri');

        if (! $uri) {
            continue;
        }

        $generator = app(\Vyuldashev\LaravelOpenApi\Generator::class);

        Route::get($uri, fn() => $generator->generate($name)->jsonSerialize())
            ->name($name.'.specification')
            ->middleware(Arr::get($config, 'route.middleware'));

    }
});
