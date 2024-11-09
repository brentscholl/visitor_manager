<?php

    use App\Http\Controllers\LocationController;
    use App\Http\Controllers\PagesController;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | This file is where you can register web routes for your application.
    | These routes are loaded by the RouteServiceProvider within a group
    | that contains the "web" middleware group. Make something great!
    |
    */

// Public route to the welcome page
    Route::get('/', function () {
        return view('welcome');
    });

// Public route to display a form by UUID
    Route::get('/forms/{code}', [LocationController::class, 'showForm'])->name('forms.show');

// Authenticated and subscribed routes
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'subscribed'])->group(function () {
        // Route to the user dashboard
        Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');

        // Route to display a location by UUID
        Route::get('/locations/{id}', [LocationController::class, 'show'])->name('locations.show');

        // Route to display submissions for a specific location by UUID
        Route::get('/locations/{id}/submissions', [LocationController::class, 'submissions'])->name('locations.submissions');
    });
