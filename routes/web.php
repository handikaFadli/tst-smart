<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientAccountController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\TicketCategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketMessageController;
use App\Http\Controllers\TicketRuleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('clients', ClientController::class);
    Route::resource('client-types', ClientTypeController::class);
    Route::resource('products', ProductController::class);
    Route::resource('servers', ServerController::class);
    Route::resource('features', FeatureController::class);
    Route::resource('accounts', ClientAccountController::class);
    Route::resource('users', UserController::class);

    Route::resource('tickets', TicketController::class);
    Route::resource('ticket-categories', TicketCategoryController::class);
    Route::resource('ticket-rules', TicketRuleController::class);

    Route::post('tickets/{ticket}/assign', [TicketController::class, 'assign'])->name('tickets.assign');
    Route::patch('tickets/{ticket}/status', [TicketController::class, 'changeStatus'])->name('tickets.changeStatus');
    Route::post('tickets/{ticket}/close', [TicketController::class, 'close'])->name('tickets.close');
    Route::get('tickets-monitoring-sla', [TicketController::class, 'monitoringSla'])->name('tickets.monitoring-sla');
    Route::get('tickets-monitoring-sla/export', [TicketController::class, 'exportSlaMonitoring'])->name('tickets.monitoring-sla.export');

    // ─── LAPORAN ───
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('tickets/export', [ReportController::class, 'exportTickets'])->name('tickets.export');
        Route::get('tickets/export-pdf', [ReportController::class, 'exportTicketsPdf'])->name('tickets.export-pdf');
        Route::get('sla/export', [ReportController::class, 'exportSla'])->name('sla.export');
        Route::get('sla/export-pdf', [ReportController::class, 'exportSlaPdf'])->name('sla.export-pdf');
        Route::get('technician/export', [ReportController::class, 'exportTechnicianPerformance'])->name('technician.export');
        Route::get('technician/export-pdf', [ReportController::class, 'exportTechnicianPerformancePdf'])->name('technician.export-pdf');
        Route::get('clients/export', [ReportController::class, 'exportClients'])->name('clients.export');
        Route::get('clients/export-pdf', [ReportController::class, 'exportClientsPdf'])->name('clients.export-pdf');
    });

    Route::post('tickets/{ticket}/messages', [TicketMessageController::class, 'store'])->name('tickets.messages.store');
    Route::get('/ticket-attachments/{attachment}/download', [TicketController::class, 'download'])->name('ticket.attachments.download');
});
