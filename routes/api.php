<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AllDataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::get('/user/{userId}', [AuthController::class, 'user']);


Route::get('/abouts', [AboutController::class, 'index']);
Route::get('/certificates', [CertificateController::class, 'index']);
Route::get('/contacts', [ContactController::class, 'index']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/skills', [SkillController::class, 'index']);
Route::get('/allData', [AllDataController::class, 'index']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('/about', [AboutController::class, 'store']);
    Route::put('/about/{aboutId}', [AboutController::class, 'update']);
    Route::delete('/about/{aboutId}', [AboutController::class, 'destroy']);

    Route::post('/certificate', [CertificateController::class, 'store']);
    Route::put('/certificate/{skillId}', [CertificateController::class, 'update']);
    Route::delete('/certificate/{skillId}', [CertificateController::class, 'destroy']);

    Route::post('/contact', [ContactController::class, 'store']);
    Route::put('/contact/{skillId}', [ContactController::class, 'update']);
    Route::delete('/contact/{skillId}', [ContactController::class, 'destroy']);

    Route::post('/project', [ProjectController::class, 'store']);
    Route::put('/project/{projectId}', [ProjectController::class, 'update']);
    Route::delete('/project/{projectId}', [ProjectController::class, 'destroy']);

    Route::post('/skill', [SkillController::class, 'store']);
    Route::put('/skill/{skillId}', [SkillController::class, 'update']);
    Route::delete('/skill/{skillId}', [SkillController::class, 'destroy']);
});
