<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ChartController;

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

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware('auth')->get('/dashboard', [MessageController::class, 'index'])->name('dashboard');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('register', function () {
    return view('auth.register');
})->name('register');

Route::get('/chart-data', [ChartController::class, 'fetchMessages']); // Nieuwe route voor het ophalen van de data voor de chart op de dashboard pagina
Route::middleware('throttle:60,1')->group(function () {
    // Route voor het ophalen van de data voor de chart op de dashboard pagina
    Route::get('/chart-data', [ChartController::class, 'fetchMessages']);
});

require __DIR__.'/auth.php';
