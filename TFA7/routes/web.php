
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;

// Home Page
Route::get('/', [PageController::class, 'index']);

// About Page
Route::get('/about', [PageController::class, 'about']);

// Customer Accounts
Route::get('/customers', [CustomerController::class, 'index'])
    ->name('customers.index');

// Customer Create Form
Route::get('/customers/create', [CustomerController::class, 'create'])
    ->name('customers.create');

// Save New Customer
Route::post('/customers', [CustomerController::class, 'store'])
    ->name('customers.store');

// User Accounts
Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');

// User Create Form
Route::get('/users/create', [UserController::class, 'create'])
    ->name('users.create');

// Save New User
Route::post('/users', [UserController::class, 'store'])
    ->name('users.store');

// Edit Existing Customer
Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])
    ->name('customers.edit');

// Update Existing Customer
Route::put('/customers/{customer}', [CustomerController::class, 'update'])
    ->name('customers.update');

    // Edit Existing User
Route::get('/users/{user}/edit', [UserController::class, 'edit'])
    ->name('users.edit');

// Update Existing User
Route::put('/users/{user}', [UserController::class, 'update'])
    ->name('users.update');