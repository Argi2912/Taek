<?php

use App\Http\Controllers\AthleteController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BeltGradeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SystemLogController;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Add the approve-single route
    Route::post('/payments/{id}/approve', [PaymentController::class, 'approveSingle'])->name('payments.approve-single');

    // Add the approve-bulk route
    Route::post('/payments/approve-bulk', [PaymentController::class, 'approveBulk'])->name('payments.approve-bulk');

    // Add the pending payments route
    Route::get('/payments/pending', [PaymentController::class, 'pending'])->name('payments.pending');

    Route::resource('documents', DocumentController::class);
    Route::get('/documents/pending', [DocumentController::class, 'pending'])->name('documents.pending');
    Route::post('/documents/{id}/approve', [DocumentController::class, 'approveSingle'])->name('documents.approve.single');
    Route::post('/documents/approve-bulk', [DocumentController::class, 'approveBulk'])->name('documents.approve.bulk');
    Route::post('/documents/{id}/reject', [DocumentController::class, 'reject'])->name('documents.reject');
    Route::get('/payments/user-payment', [PaymentController::class, 'userPayment'])->name('payments.user-payment');
    Route::post('/payments/user-store', [PaymentController::class, 'userStore'])->name('payments.user-store');
    Route::post('/events/{event}/register', [EventController::class, 'register'])->name('events.register');
    Route::resource('/eventregistration', EventRegistrationController::class);
    Route::get('/eventregistration/createEvent/{event}', [EventRegistrationController::class, 'createEvent'])->name('eventregistration.createEvent');
    Route::put('/events/{id}/update-categories', [EventController::class, 'updateCategories'])
        ->name('events.update-categories');
    // Agregar esta ruta para el endpoint de eventos disponibles
    Route::get('/api/athletes/{athlete}/available-events', [PaymentController::class, 'getAvailableEvents']);
    Route::get('/athlete/{id}/print-constancy', [AthleteController::class, 'printConstancy'])
        ->name('athlete.print-constancy');

    Route::patch('/athletes/{id}/toggle-status', [AthleteController::class, 'toggleStatus'])->name('athlete.toggle-status');
    Route::patch('/categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    Route::get('/payments/{id}/receipt', [PaymentController::class, 'generateReceipt'])->name('payments.receipt');
    //Route::get('/logs', [SystemLogController::class, 'index'])->name('logs.index');
    //Route::get('/logs', [SystemLogController::class, 'index'])->name('logs.index');
    Route::resource('/logs', SystemLogController::class);

    Route::get('/manual', [ManualController::class, 'index'])->name('manual.index');

});

Route::resource('/roles', RoleController::class)->middleware('auth');

Route::post('/roles/assign/{user}', [RoleController::class, 'assignRole'])->name('roles.assign')->middleware('auth');

Route::resource('/athlete', AthleteController::class)->middleware('auth');
Route::resource('/categories', CategoryController::class)->middleware('auth');
Route::resource('/belts', BeltGradeController::class)->middleware('auth');
Route::resource('/payments', PaymentController::class)->middleware('auth');
Route::resource('/events', EventController::class)->middleware('auth');
Route::resource('/venues', VenueController::class)->middleware('auth');
Route::post('/backup/create', [BackupController::class, 'create'])->name('backup.create')->middleware('auth');


// Rutas para pagos pendientes


require __DIR__ . '/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
