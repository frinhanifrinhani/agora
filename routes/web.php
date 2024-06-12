<?php

use Dotenv\Exception\ValidationException as ExceptionValidationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/noticias', function () {
    return view('noticias.index');
});
