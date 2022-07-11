<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AnimalKindController;
use App\Http\Controllers\AnimalSessionController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', HomeController::class);

Route::get('animal_session', [AnimalSessionController::class, 'create'])->name('animal_session.create');

Route::get('animal_kinds', [AnimalKindController::class, 'all'])->name('animal_kinds');

Route::controller(AnimalController::class)->group(function (){
    Route::post('animal', 'create')->name('animal.create');
    Route::post('animal/age', 'age')->name('animal.age');
});

