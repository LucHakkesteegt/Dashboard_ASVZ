<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
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


Route::get('/chart-data', [ChartController::class, 'fetchMessages']); // Nieuwe route voor het ophalen van de data voor de chart op de dashboard pagina

Route::get('/', [MessageController::class, 'index']); // route om de dashboard pagina te tonen bij het opstarten van de applicatie