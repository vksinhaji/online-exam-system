<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DocumentRequirementController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\ProgressUpdateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return redirect()->route('dashboard'); });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin only routes
    Route::middleware('role:admin')->group(function () {
        Route::resource('customers', CustomerController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('document-requirements', DocumentRequirementController::class);
    });

    // Admin + Staff routes
    Route::middleware('role:admin|staff')->group(function () {
        Route::resource('service-requests', ServiceRequestController::class)->only(['index','show','create','store','edit','update']);
        Route::post('service-requests/{service_request}/progress', [ProgressUpdateController::class, 'store'])->name('service-requests.progress.store');

        // Enquiries (capture leads before creating full service request)
        Route::resource('enquiries', EnquiryController::class);
        Route::get('enquiries/{enquiry}/print', [EnquiryController::class, 'print'])->name('enquiries.print');
        Route::get('enquiries/{enquiry}/pdf', [EnquiryController::class, 'pdf'])->name('enquiries.pdf');
    });
});

require __DIR__.'/auth.php';
