<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[TeacherController::class,'index'])->name('teachers');
Route::get('/teacher/create',[TeacherController::class,'create'])->name('teacher.create');
Route::post('/teacher/store',[TeacherController::class,'store'])->name('teacher.store');
Route::get('/teacher/edit/{id}',[TeacherController::class,'edit'])->name('teacher.edit');
Route::post('/teacher/update',[TeacherController::class,'update'])->name('teacher.update');
Route::delete('/teacher/delete/{id}',[TeacherController::class,'delete'])->name('teacher.delete');

