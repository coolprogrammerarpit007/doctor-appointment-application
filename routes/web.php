<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Api\V1\AppointmentController;
use App\Http\Controllers\Admin\AppointmentController as adminAppointmentController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->middleware(['auth'])->group(function(){
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/appointments', [adminAppointmentController::class, 'index'])->name('admin.appointments.index');
    Route::post('/appointments/{appointment}/cancel', [adminAppointmentController::class, 'cancel'])->name('admin.appointments.cancel');
    Route::post('/appointments/{appointment}/complete', [adminAppointmentController::class, 'complete'])->name('admin.appointments.complete');

    // Doctors Management System

    Route::resource('/doctors', DoctorController::class)
    ->names('admin.doctors');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
