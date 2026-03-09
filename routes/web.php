<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MfiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
   
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
   
    // MFI routes (viewable by all authenticated users)
    Route::get('/mfi', [MfiController::class, 'index'])->name('mfi.index');
    Route::get('/mfi/{mfi}', [MfiController::class, 'show'])->name('mfi.show');
   
    // Export routes (available to all authenticated users)
    Route::get('/export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export/csv', [ExportController::class, 'exportCsv'])->name('export.csv');
    Route::get('/export/pdf', [ExportController::class, 'exportPdf'])->name('export.pdf');

    // Admin only routes
    Route::middleware('admin')->group(function () {
        // MFI Edit/Delete
        Route::get('/mfi/{mfi}/edit', [MfiController::class, 'edit'])->name('mfi.edit');
        Route::put('/mfi/{mfi}', [MfiController::class, 'update'])->name('mfi.update');
        Route::delete('/mfi/{mfi}', [MfiController::class, 'destroy'])->name('mfi.destroy');
        Route::get('/mfi-trashed', [MfiController::class, 'trashed'])->name('mfi.trashed');
        Route::post('/mfi/{id}/restore', [MfiController::class, 'restore'])->name('mfi.restore');

        Route::get('/api/districts', function (Request $request) {
            $divisions = $request->input('divisions', []);
            if (empty($divisions)) {
                $districts = \App\Models\Mfi::select('district')
                    ->distinct()
                    ->whereNotNull('district')
                    ->orderBy('district')
                    ->pluck('district');
            } else {
                $districts = \App\Models\Mfi::select('district')
                    ->distinct()
                    ->whereIn('division', $divisions)
                    ->whereNotNull('district')
                    ->orderBy('district')
                    ->pluck('district');
            }
            return response()->json($districts);
        })->name('api.districts');

        // User Management
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});