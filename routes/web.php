<?php

use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MicropostsController; //追記

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MicropostsController::class, 'index']);

Route::get('/dashboard', [MicropostsController::class, 'index'])->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth']], function () {
    Route::resource('taskes', TasksController::class);
    Route::resource('microposts', MicropostsController::class, ['only' => ['store', 'destroy']]);
});

