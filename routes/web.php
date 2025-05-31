<?php

use App\Http\Controllers\CertificationController;
use App\Http\Controllers\ExperienceController;
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

// Accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Mon compte
Route::middleware('auth')->group(function () {
    Route::get('/account', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/account', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// FREELANCES
// Catalogue des freelances
Route::get('/freelance', [FreelanceController::class, 'index'])->name('freelance.index');

// Profil d'un freelance
Route::get('/freelance/{slug}', [FreelanceController::class, 'show'])->name('freelance.show');

// Modification du profil freelance
Route::middleware(['auth', 'can:update,freelance'])->group(function () {
    Route::post('/freelance/{freelance}/update-images', [FreelanceController::class, 'updateImage'])->name('freelance.updateImages');
    Route::put('/freelance/{freelance}/update-bio', [FreelanceController::class, 'updateBio'])->name('freelance.updateBio');
    Route::put('/freelance/{freelance}/infos', [FreelanceController::class, 'updateInfos'])->name('freelance.updateInfos');
    Route::put('/freelances/{freelance}/professions', [FreelanceController::class, 'updateProfessions'])->name('freelances.updateProfessions');
    Route::put('/freelances/{freelance}/skills', [FreelanceController::class, 'updateSkills'])->name('freelances.updateSkills');
});

// Certifications
Route::middleware(['auth'])->group(function () {
    Route::post('/certifications', [CertificationController::class, 'store'])->name('certifications.store');
    Route::put('/certifications/{certification}', [CertificationController::class, 'update'])->name('certifications.update')->can('update', 'certification');
    Route::delete('/certifications/{certification}', [CertificationController::class, 'destroy'])->name('certifications.destroy')->can('update', 'certification');
});

// Experiences
Route::middleware(['auth'])->group(function () {
    Route::post('/experiences', [ExperienceController::class, 'store'])->name('experiences.store');
    Route::put('/experiences/{experience}', [ExperienceController::class, 'update'])->name('experiences.update')->can('update', 'experience');
    Route::delete('/experiences/{experience}', [ExperienceController::class, 'destroy'])->name('experiences.destroy')->can('update', 'experience');
});



// Pages légales

Route::get('/cgu', fn() => Inertia::render('Legal/CGU'))->name('cgu');
Route::get('/cgv', fn() => Inertia::render('Legal/CGV'))->name('cgv');
Route::get('/politique-de-confidentialite', fn() => Inertia::render('Legal/Privacy'))->name('privacy');
Route::get('/mentions-legales', fn() => Inertia::render('Legal/Mentions'))->name('mentions');

require __DIR__.'/auth.php';
