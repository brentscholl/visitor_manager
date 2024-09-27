<?php

    use App\Http\Controllers\LocationController;
    use App\Http\Controllers\PagesController;
    use Illuminate\Support\Facades\Route;

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

Route::get('/forms/{uuid}', [LocationController::class, 'showForm'])->name('forms.show');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'subscribed'])->group(function () {
    Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');
    Route::get('/locations/{uuid}', [LocationController::class, 'show'])->name('locations.show');
    Route::get('/locations/{uuid}/submissions', [LocationController::class, 'submissions'])->name('locations.submissions');
});
