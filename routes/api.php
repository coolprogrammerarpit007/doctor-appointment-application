<?php

use App\Http\Controllers\Api\V1\AppointmentController;
use App\Http\Controllers\Api\V1\DoctorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// ******************************   API Routes ****************************

Route::prefix('v1')->group(function(){

    //  for all the doctors
    Route::apiResource('doctors',DoctorController::class)->only(['index','show']);

    // Availability for a specific doctor on specific date and time
    Route::get('doctors/{id}/availability',[DoctorController::class,'availability']);


    // Book Appointments
    Route::post('appointments',[AppointmentController::class,'store']);
});



// *************************************************************************
