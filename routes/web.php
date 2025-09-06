<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Jobs\LoggerJob;
use App\Models\Job;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');


// // Old routes without middleware and policy
// Route::get('/jobs', [JobController::class, 'index']);
// Route::get('/jobs/create', [JobController::class, 'create']);
// Route::post('/jobs', [JobController::class, 'store']);
// Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');
// Route::get('/jobs/{id}/edit', [JobController::class, 'edit']);
// Route::patch('/jobs/{id}', [JobController::class, 'update']);
// Route::delete('/jobs/{id}', [JobController::class, 'destroy']);
// // Dedicated route for implementing a simple queue and job for logging messages
// Route::get('/contact', function () {
//     $job = Job::first();
//     LoggerJob::dispatch($job);
//     return view('contact');
// });

Route::get('/contact', function () {
    $job = Job::first();
    LoggerJob::dispatch($job);
    return view('contact');
});

Route::middleware('auth')->group(function () {

    Route::get('/email/verify', [RegisteredUserController::class, 'index'])
        ->name('verification.notice');

});

Route::middleware(['auth', 'signed'])->group(function () {

    Route::get('/email/verify/{id}/{hash}', [RegisteredUserController::class, 'verify'])
        ->name('verification.verify');

});

Route::middleware(['auth', 'throttle:6,1'])->group(function () {
    

    Route::post('/email/verification-notification', [RegisteredUserController::class, 'resend'])
        ->name('verification.send');

});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/jobs', [JobController::class, 'index']);
    Route::post('/jobs', [JobController::class, 'store']);

    Route::get('/jobs/create', [JobController::class, 'create']);

    Route::get('/jobs/{job}', [JobController::class, 'show'])
        ->name('jobs.show');
    Route::get('/jobs/{job}/edit', [JobController::class, 'edit']);

    Route::can('edit', 'job')->group(function () {
        Route::patch('/jobs/{job}', [JobController::class, 'update']);
        Route::delete('/jobs/{job}', [JobController::class, 'destroy']);
    });

});

Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->name('register.store');

Route::get('/login', [UserController::class, 'create'])
    ->name('login');
Route::post('/login', [UserController::class, 'store']);
Route::post('/logout', [UserController::class, 'destroy'])
    ->name('logout');