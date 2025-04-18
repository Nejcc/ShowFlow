<?php

declare(strict_types=1);

use App\Http\Controllers\PresentationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/presentation', [PresentationController::class, 'index']);
