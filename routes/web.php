<?php

use App\Http\Controllers\AturanController;
use App\Http\Controllers\FaktorController;
use App\Http\Controllers\GejalaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MentalController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UsersController;

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
Route::post('/profile{id}', [HomeController::class,'editProfile'])->name('editProfile');
Route::post('/profile', [HomeController::class,'updateProfile'])->name('postProfile');

Route::get('/hasil{id}', [HomeController::class,'getTestResult'])->name('getTestResult');
Route::post('/edithasil{id}', [HomeController::class,'editHasil'])->name('editHasil');
Route::post('/updatehasil', [HomeController::class,'updateHasil'])->name('updateHasil');
Route::delete('/hasil{id}', [HomeController::class,'deleteHasil'])->name('deleteHasil');

Route::get('/question', [QuestionController::class,'index'])->name('question');
Route::get('/getquestion{id}', [QuestionController::class,'getData'])->name('getquestion');
Route::post('/question', [QuestionController::class,'save'])->name('postQuestion');
Route::post('/editquestion{id}', [QuestionController::class,'edit'])->name('editQuestion');
Route::post('/updatequestion', [QuestionController::class,'update'])->name('updateQuestion');
Route::delete('/question{id}', [QuestionController::class,'delete'])->name('deleteQuestion');

Route::get('/users', [UsersController::class,'index'])->name('user');
Route::post('/users', [UsersController::class,'save'])->name('postUser');
Route::post('/edituser{id}', [UsersController::class,'edit'])->name('edituser');
Route::post('/updateuser', [UsersController::class,'update'])->name('updateuser');
Route::delete('/user{id}', [UsersController::class,'delete'])->name('deleteUser');

Route::get('/mental', [MentalController::class,'index'])->name('mental');
Route::post('/mental', [MentalController::class,'save'])->name('postMental');
Route::post('/editmental{id}', [MentalController::class,'edit'])->name('editMental');
Route::post('/updatemental', [MentalController::class,'update'])->name('updateMental');
Route::delete('/mental{id}', [MentalController::class,'delete'])->name('deleteMental');

Route::get('/factor', [FaktorController::class,'index'])->name('factor');
Route::get('/getfactor{id}', [FaktorController::class,'getData'])->name('getfactor');
Route::post('/factor', [FaktorController::class,'save'])->name('postFaktor');
Route::post('/editfaktor{id}', [FaktorController::class,'edit'])->name('editFaktor');
Route::post('/updatefaktor', [FaktorController::class,'update'])->name('updateFaktor');
Route::delete('/factor{id}', [FaktorController::class,'delete'])->name('deleteFaktor');

Route::get('/aturan', [AturanController::class,'index'])->name('aturan');
Route::post('/aturan{id}', [AturanController::class,'getKategori'])->name('getKategori');
Route::get('/getaturan{id}', [AturanController::class,'getData'])->name('getaturan');
Route::post('/aturan', [AturanController::class,'save'])->name('postAturan');
Route::post('/editaturan{id}', [AturanController::class,'edit'])->name('editAturan');
Route::post('/updateaturan', [AturanController::class,'update'])->name('updateAturan');
Route::delete('/aturan{id}', [AturanController::class,'delete'])->name('deleteAturan');

Route::post('/kategori', [KategoriController::class,'save'])->name('postKategori');
Route::post('/updatekategori', [KategoriController::class,'update'])->name('updateKategori');
Route::delete('/kategori{id}', [KategoriController::class,'delete'])->name('deleteKategori');

Route::get('/gejala', [GejalaController::class,'index'])->name('gejala');
Route::get('/getgejala{id}', [GejalaController::class,'getData'])->name('getgejala');
Route::post('/gejala', [GejalaController::class,'save'])->name('postGejala');
Route::post('/editgejala{id}', [GejalaController::class,'edit'])->name('editGejala');
Route::post('/updategejala', [GejalaController::class,'update'])->name('updateGejala');
Route::delete('/gejala{id}', [GejalaController::class,'delete'])->name('deleteGejala');

Route::get('/home', [HomeController::class,'home'])->name('home');
Route::get('/about', [HomeController::class,'about'])->name('about');
Route::get('/test/{id}', [HomeController::class, 'test'])->name('test');
Route::post('/test', [HomeController::class, 'saveTest'])->name('saveTest');
Route::get('/test-result/{id}', [HomeController::class, 'testResult'])->name('testResult');