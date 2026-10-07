<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MerchController;

/*
|--------------------------------------------------------------------------
| Web Routes - ICS Apparel & Merch Reservation System
| Integrated Computer Society
| Midterm Project - AIS 2B Group 4
|--------------------------------------------------------------------------
*/

// Main Application View (Dashboard, Info Mgmt, Reports, User Mgmt, Activity Logs, Student Portal)
Route::get('/', [MerchController::class, 'index'])->name('home');

// API & AJAX Endpoints
Route::get('/api/catalog', [MerchController::class, 'getCatalog'])->name('api.catalog');
Route::post('/api/reservations', [MerchController::class, 'storeReservation'])->name('api.reservations.store');
Route::patch('/api/reservations/{id}/status', [MerchController::class, 'updateReservationStatus'])->name('api.reservations.status');

// Products (Information Management CRUD with Image Upload & Edit)
Route::post('/api/products', [MerchController::class, 'storeProduct'])->name('api.products.store');
Route::post('/api/products/{id}', [MerchController::class, 'updateProduct'])->name('api.products.update');
Route::delete('/api/products/{id}', [MerchController::class, 'deleteProduct'])->name('api.products.delete');

// User Management CRUD
Route::post('/api/users', [MerchController::class, 'storeUser'])->name('api.users.store');
Route::put('/api/users/{id}', [MerchController::class, 'updateUser'])->name('api.users.update');
Route::delete('/api/users/{id}', [MerchController::class, 'deleteUser'])->name('api.users.delete');

// Reports Export
Route::get('/reports/export-csv', [MerchController::class, 'exportReportCsv'])->name('reports.export');

// Support Helpdesk & Chat API
Route::get('/api/support/tickets', [MerchController::class, 'getSupportTickets'])->name('api.support.tickets');
Route::get('/api/support-tickets', [MerchController::class, 'getSupportTickets']);

Route::post('/api/support/tickets', [MerchController::class, 'storeSupportTicket'])->name('api.support.tickets.store');
Route::post('/api/support-tickets', [MerchController::class, 'storeSupportTicket']);

Route::get('/api/support/tickets/{id}/messages', [MerchController::class, 'getTicketMessages'])->name('api.support.tickets.messages');
Route::get('/api/support-tickets/{id}/messages', [MerchController::class, 'getTicketMessages']);

Route::post('/api/support/tickets/{id}/messages', [MerchController::class, 'storeTicketMessage'])->name('api.support.tickets.messages.store');
Route::post('/api/support-tickets/{id}/messages', [MerchController::class, 'storeTicketMessage']);

Route::patch('/api/support/tickets/{id}/status', [MerchController::class, 'updateTicketStatus'])->name('api.support.tickets.status');
Route::patch('/api/support-tickets/{id}/status', [MerchController::class, 'updateTicketStatus']);

Route::post('/api/support/tickets/{id}/cancel-reservation', [MerchController::class, 'cancelReservationFromTicket'])->name('api.support.tickets.cancel');
Route::post('/api/support-tickets/{id}/cancel-reservation', [MerchController::class, 'cancelReservationFromTicket']);