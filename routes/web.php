<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::get('forms/{form}', [FormController::class, 'show'])->name('forms.show');

Route::post('/forms/{form}', [FormController::class, 'fill'])->name('forms.fill');
