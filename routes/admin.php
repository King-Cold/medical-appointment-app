<?php

use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::get('/',function(){
  return view('admin.dashboard');

})->name('dashboard');



//Gestion de roles

Route::resource('roles', RoleController::class);
//Gestion de usuarios

Route::resource('users', UserController::class);

//Gestion de usuarios
Route::resource('patients', PatientController::class);

//Gestion de doctores
Route::get('doctors', [\App\Http\Controllers\Admin\DoctorController::class, 'index'])->name('doctors.index');
Route::get('doctors/create', [\App\Http\Controllers\Admin\DoctorController::class, 'create'])->name('doctors.create');
Route::get('doctors/{id}/horario', [\App\Http\Controllers\Admin\DoctorController::class, 'schedule'])->name('doctors.schedule');
Route::get('doctors/{id}/edit', [\App\Http\Controllers\Admin\DoctorController::class, 'edit'])->name('doctors.edit');

//Gestion de citas
Route::resource('appointments', \App\Http\Controllers\Admin\AppointmentController::class);

//Gestion de consultas
Route::get('consultations/{appointment}', \App\Livewire\Admin\ConsultationManager::class)->name('consultations.manager');
?>