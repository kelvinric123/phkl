<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsultantController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\SurgicalProcedureController;
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
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Consultants, Patients, and Invoices routes
Route::middleware(['auth'])->group(function () {
    // Consultant routes
    Route::get('/consultants', [ConsultantController::class, 'index'])->name('consultants.index');
    Route::get('/consultants/create', [ConsultantController::class, 'create'])->name('consultants.create');
    Route::post('/consultants', [ConsultantController::class, 'store'])->name('consultants.store');
    Route::get('/consultants/{consultant}', [ConsultantController::class, 'show'])->name('consultants.show');
    Route::get('/consultants/{consultant}/edit', [ConsultantController::class, 'edit'])->name('consultants.edit');
    Route::put('/consultants/{consultant}', [ConsultantController::class, 'update'])->name('consultants.update');
    Route::delete('/consultants/{consultant}', [ConsultantController::class, 'destroy'])->name('consultants.destroy');
    
    // Patient routes
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/search/mrn/{mrn}', [PatientController::class, 'searchByMrn'])->name('patients.search.mrn');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');
    
    // Invoice routes
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
    Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
    
    // Specialty routes
    Route::get('/specialties', [SpecialtyController::class, 'index'])->name('specialties.index');
    Route::get('/specialties/create', [SpecialtyController::class, 'create'])->name('specialties.create');
    Route::post('/specialties', [SpecialtyController::class, 'store'])->name('specialties.store');
    Route::get('/specialties/{specialty}', [SpecialtyController::class, 'show'])->name('specialties.show');
    Route::get('/specialties/{specialty}/edit', [SpecialtyController::class, 'edit'])->name('specialties.edit');
    Route::put('/specialties/{specialty}', [SpecialtyController::class, 'update'])->name('specialties.update');
    Route::delete('/specialties/{specialty}', [SpecialtyController::class, 'destroy'])->name('specialties.destroy');
    
    // Surgical Procedure routes
    Route::get('/surgical-procedures', [SurgicalProcedureController::class, 'index'])->name('surgical-procedures.index');
    // API route for autocomplete - must come before any routes with parameters
    Route::get('/surgical-procedures/search', [SurgicalProcedureController::class, 'search'])->name('surgical-procedures.search');
    Route::get('/surgical-procedures/create', [SurgicalProcedureController::class, 'create'])->name('surgical-procedures.create');
    Route::post('/surgical-procedures', [SurgicalProcedureController::class, 'store'])->name('surgical-procedures.store');
    Route::get('/surgical-procedures/{surgicalProcedure}', [SurgicalProcedureController::class, 'show'])->name('surgical-procedures.show');
    Route::get('/surgical-procedures/{surgicalProcedure}/edit', [SurgicalProcedureController::class, 'edit'])->name('surgical-procedures.edit');
    Route::put('/surgical-procedures/{surgicalProcedure}', [SurgicalProcedureController::class, 'update'])->name('surgical-procedures.update');
    Route::delete('/surgical-procedures/{surgicalProcedure}', [SurgicalProcedureController::class, 'destroy'])->name('surgical-procedures.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
