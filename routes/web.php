
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Homecontroller;
use App\Http\Middleware\AuthAdmin;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', [Homecontroller::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(AuthAdmin::class)->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');

    Route::get('/admin/brands/add', [AdminController::class, 'addBrand'])->name('admin.brands.add');

    Route::post('/admin/brands', [AdminController::class, 'storeBrand'])->name('admin.brands.store');

    Route::get('/admin/brands/{id}/edit', [AdminController::class, 'brandEdit'])->name('admin.brands.edit');

    Route::put('/admin/brands/{id}', [AdminController::class, 'updateBrand'])
    ->name('admin.brands.update');

    Route::delete('/admin/brands/{id}', [AdminController::class, 'deleteBrand'])->name('admin.brands.delete');

    Route::delete('/brands/{id}', [AdminController::class, 'deleteBrand'])
    ->name('brands.delete');
});

require __DIR__.'/auth.php';
