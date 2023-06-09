<?php

use App\Models\Habit;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\HabitsController;

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
    return view('welcome');
});

Route::get('/habits', [HabitsController::class, 'index'])->name('habits.index');
Route::post('/habits', [HabitsController::class, 'store'])->name('habits.store');
Route::put("/habits/{habit}", [HabitsController::class, 'update'])->name('habits.update');
Route::delete("/habits/{habit}", [HabitsController::class, 'destroy'])->name('habits.destroy');
