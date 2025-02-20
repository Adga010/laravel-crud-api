<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\StudentController;

route::get('/students', [StudentController::class, 'index']);

Route::get('/student/{id}', [StudentController::class, 'show']);

route::post('/student', [StudentController::class, 'store']);

Route::put('/student/{id}', [StudentController::class, 'update']);

Route::delete('/student/{id}', [StudentController::class, 'destroy']);