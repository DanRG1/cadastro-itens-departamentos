<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\ItemsController;

Route::apiResource('departments', DepartamentoController::class);
Route::apiResource('items', ItemsController::class);

Route::get('/', function () {
    return view('welcome');
});
