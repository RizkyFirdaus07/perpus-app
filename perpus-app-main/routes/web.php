
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index']);

Route::get('/tentang', [HomeController::class, 'tentang']);

Route::get('/kontak', [HomeController::class, 'kontak']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('books', BookController::class);
});

require __DIR__.'/auth.php';

