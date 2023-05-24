<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ReportController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('valas', ValasController::class);
Route::resource('customers', CustomerController::class);
Route::resource('memberships', MembershipController::class);

Route::resource('transactions', TransactionController::class);
Route::resource('transaction-details', TransactionDetailController::class);

Route::middleware(['auth', 'admin'])->group(function () {
    // Rute yang hanya dapat diakses oleh admin
    Route::resource('valas', ValasController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('transactions', TransactionController::class);
});

Route::middleware(['auth', 'superadmin'])->group(function () {
    // Rute yang hanya dapat diakses oleh superadmin
    Route::put('memberships/{membership}', [MembershipController::class, 'update'])->name('memberships.update');
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
});

Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
Route::post('reports/filter', [ReportController::class, 'filter'])->name('reports.filter');


require __DIR__.'/auth.php';
