<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MerchController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\StudentAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes - ICS Apparel & Merch Reservation System
| Integrated Computer Society
| Midterm Project
|--------------------------------------------------------------------------
*/

// Local ICS Student Portal Identity & Direct Login (No External Redirects)
Route::post('/student/login', [StudentAuthController::class, 'login'])->name('student.login');
Route::post('/student/quick-login/{id}', [StudentAuthController::class, 'quickLogin'])->name('student.quick_login');
Route::match(['get', 'post'], '/student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
Route::get('/api/students', [StudentAuthController::class, 'list'])->name('api.students.list');
Route::get('/api/student/current', [StudentAuthController::class, 'current'])->name('api.student.current');

// OnePass OAuth Routes (RFC 6749 & RFC 7636 PKCE S256 SSO)
Route::get('/oauth/login', [OAuthController::class, 'redirect'])->name('oauth.login');
Route::get('/oauth/callback', [OAuthController::class, 'callback'])->name('oauth.callback');
Route::match(['get', 'post'], '/oauth/logout', [OAuthController::class, 'logout'])->name('oauth.logout');

// Main Application Views (Student Store & Dedicated Admin Portal)
Route::get('/', [MerchController::class, 'index'])->name('home');
Route::get('/admin', [MerchController::class, 'admin'])->name('admin');
Route::get('/admin/dashboard', [MerchController::class, 'admin'])->name('admin.dashboard');

Route::get('/api/realtime/sync', [MerchController::class, 'getRealtimeSync'])->name('api.realtime.sync');
Route::get('/api/realtisyncme/', [MerchController::class, 'getRealtimeSync']);
Route::get('/api/catalog', [MerchController::class, 'getCatalog'])->name('api.catalog');
Route::post('/api/reservations', [MerchController::class, 'storeReservation'])->name('api.reservations.store');
Route::patch('/api/reservations/{id}/status', [MerchController::class, 'updateReservationStatus'])->name('api.reservations.status');
Route::delete('/api/reservations/{id}', [MerchController::class, 'destroyReservation'])->name('api.reservations.destroy');

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

Route::delete('/api/support/tickets/{id}', [MerchController::class, 'deleteTicket'])->name('api.support.tickets.delete');
Route::delete('/api/support-tickets/{id}', [MerchController::class, 'deleteTicket']);