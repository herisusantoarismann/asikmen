<?php

use App\Http\Controllers\FaktorController;
use App\Http\Controllers\GejalaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MentalController;
use App\Http\Controllers\QuestionController;

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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/', [LoginController::class, 'login'])->name('postLogin');
Route::post('/postRegister', [LoginController::class, 'save'])->name('postRegister');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [HomeController::class,'index'])->name('dashboard');
Route::get('/profile', [HomeController::class,'profile'])->name('profile');

Route::get('/question', [QuestionController::class,'index'])->name('question');
Route::post('/question', [QuestionController::class,'save'])->name('postQuestion');
Route::post('/editquestion{id}', [QuestionController::class,'edit'])->name('editQuestion');
Route::post('/updatequestion', [QuestionController::class,'update'])->name('updateQuestion');
Route::delete('/question{id}', [QuestionController::class,'delete'])->name('deleteQuestion');

Route::get('/mental', [MentalController::class,'index'])->name('mental');
Route::post('/mental', [MentalController::class,'save'])->name('postMental');
Route::post('/editmental{id}', [MentalController::class,'edit'])->name('editMental');
Route::post('/updatemental', [MentalController::class,'update'])->name('updateMental');
Route::delete('/mental{id}', [MentalController::class,'delete'])->name('deleteMental');

Route::get('/factor', [FaktorController::class,'index'])->name('factor');
Route::post('/factor', [FaktorController::class,'save'])->name('postFaktor');
Route::post('/editfaktor{id}', [FaktorController::class,'edit'])->name('editFaktor');
Route::post('/updatefaktor', [FaktorController::class,'update'])->name('updateFaktor');
Route::delete('/factor{id}', [FaktorController::class,'delete'])->name('deleteFaktor');

Route::get('/gejala', [GejalaController::class,'index'])->name('gejala');
Route::post('/gejala', [GejalaController::class,'save'])->name('postGejala');
Route::post('/editgejala{id}', [GejalaController::class,'edit'])->name('editGejala');
Route::post('/updategejala', [GejalaController::class,'update'])->name('updateGejala');
Route::delete('/gejala{id}', [GejalaController::class,'delete'])->name('deleteGejala');

Route::get('/home', [HomeController::class,'home'])->name('home');
Route::get('/about', [HomeController::class,'about'])->name('about');
Route::get('/test', [HomeController::class, 'test'])->name('test');
Route::post('/test', [HomeController::class, 'saveTest'])->name('saveTest');
Route::get('/test-result', [HomeController::class, 'testResult'])->name('testResult');