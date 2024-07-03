<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\RecordController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and assigned to the "web"
| middleware group. Now create something great!
|
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::post('/subscribe', [GuestController::class, 'subscribe'])->name('subscribe');
Route::post('/contact', [GuestController::class, 'store'])->name('contact.store');

// Authentication routes
Auth::routes(['register' => false, 'reset' => false]);

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::delete('/images/{image}', [ImageController::class, 'destroy'])->name('images.destroy');

    Route::get('transactions/export', [TransactionController::class, 'export'])->name('transactions.export');
    Route::post('transactions/import', [TransactionController::class, 'import'])->name('transactions.import');

    Route::get('records/export', [RecordController::class, 'export'])->name('records.export');
    Route::post('records/import', [RecordController::class, 'import'])->name('records.import');

    Route::resource('contacts', ContactController::class)->only(['index', 'destroy', 'show']);

    Route::post('expenses/import', [ExpenseController::class, 'import'])->name('expenses.import');
    Route::get('expenses/export', [ExpenseController::class, 'export'])->name('expenses.export');

    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
        'products' => ProductController::class,
        'companies' => CompanyController::class,
        'customers' => CustomerController::class,
        'transactions' => TransactionController::class,
        'records' => RecordController::class,
        'expenses' => ExpenseController::class
    ]);
});
