<?php

use App\Http\Controllers\FreelanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::fallback(fn() => inertia()->render('Error', [
    'status'  => 404,
    'message' => 'Page introuvable'
]))->withoutMiddleware('auth');


Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/freelance', [FreelanceController::class, 'index'])->name('freelance.index');
Route::get('/freelance/{slug}', [FreelanceController::class, 'show'])->name('freelance.show');

Route::post('/freelance/update-images', [FreelanceController::class, 'updateImage'])
    ->middleware(['auth'])
    ->name('profile.updateImages');

// Pages légales

Route::get('/cgu', fn() => Inertia::render('Legal/CGU'))->name('cgu');
Route::get('/cgv', fn() => Inertia::render('Legal/CGV'))->name('cgv');
Route::get('/politique-de-confidentialite', fn() => Inertia::render('Legal/Privacy'))->name('privacy');
Route::get('/mentions-legales', fn() => Inertia::render('Legal/Mentions'))->name('mentions');

require __DIR__.'/auth.php';
