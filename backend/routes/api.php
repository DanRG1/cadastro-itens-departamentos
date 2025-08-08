<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DepartmentController;

Route::apiResource('items', ItemController::class);
Route::apiResource('departments', DepartmentController::class);



