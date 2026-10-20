<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MerchController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\PaymentSandboxController;

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
Route::match(['get', 'post'], '/admin/logout', [MerchController::class, 'adminLogout'])->name('admin.logout');

Route::get('/api/realtime/sync', [MerchController::class, 'getRealtimeSync'])->name('api.realtime.sync');
Route::get('/api/realtisyncme/', [MerchController::class, 'getRealtimeSync']);
Route::get('/api/catalog', [MerchController::class, 'getCatalog'])->name('api.catalog');
Route::post('/api/reservations', [MerchController::class, 'storeReservation'])->name('api.reservations.store');
Route::patch('/api/reservations/{id}/status', [MerchController::class, 'updateReservationStatus'])->name('api.reservations.status');
Route::delete('/api/reservations/{id}', [MerchController::class, 'destroyReservation'])->name('api.reservations.destroy');
Route::post('/api/reservations/bulk-delete', [MerchController::class, 'bulkDeleteReservations'])->name('api.reservations.bulk_delete');
Route::post('/api/reservations/delete-all-claimed', [MerchController::class, 'deleteAllClaimedReservations'])->name('api.reservations.delete_all_claimed');

// Products (Information Management CRUD with Image Upload & Edit)
Route::post('/api/products', [MerchController::class, 'storeProduct'])->name('api.products.store');
Route::post('/api/products/{id}', [MerchController::class, 'updateProduct'])->name('api.products.update');
Route::delete('/api/products/{id}', [MerchController::class, 'deleteProduct'])->name('api.products.delete');

// User Management CRUD
Route::post('/api/users', [MerchController::class, 'storeUser'])->name('api.users.store');
Route::put('/api/users/{id}', [MerchController::class, 'updateUser'])->name('api.users.update');
Route::delete('/api/users/{id}', [MerchController::class, 'deleteUser'])->name('api.users.delete');

// Reports Export & Claimed Releases Logsheet
Route::get('/reports/export-csv', [MerchController::class, 'exportReportCsv'])->name('reports.export');
Route::get('/reports/export-pdf', [MerchController::class, 'exportReportPdf'])->name('reports.export_pdf');
Route::get('/reports/export-claimed-csv', [MerchController::class, 'exportClaimedLedgerCsv'])->name('reports.export_claimed');
Route::get('/reports/export-claimed-pdf', [MerchController::class, 'exportClaimedPdf'])->name('reports.export_claimed_pdf');
Route::get('/api/reports/claimed-logs', [MerchController::class, 'getClaimedLogs'])->name('api.reports.claimed_logs');

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

Route::post('/api/support/tickets/{id}/edit-reservation', [MerchController::class, 'editReservationFromTicket'])->name('api.support.tickets.edit_reservation');
Route::post('/api/support-tickets/{id}/edit-reservation', [MerchController::class, 'editReservationFromTicket']);

Route::delete('/api/support/tickets/{id}', [MerchController::class, 'deleteTicket'])->name('api.support.tickets.delete');
Route::delete('/api/support-tickets/{id}', [MerchController::class, 'deleteTicket']);

// Activity Logs API
Route::get('/api/activity-logs', [MerchController::class, 'getActivityLogs'])->name('api.activity.logs');
Route::delete('/api/activity-logs', [MerchController::class, 'clearActivityLogs'])->name('api.activity.logs.clear');
Route::post('/api/activity-logs/clear', [MerchController::class, 'clearActivityLogs']);

// Student Directory & Moderation API (Snooze, Ban, Unban)
Route::post('/api/students/{id}/snooze', [MerchController::class, 'snoozeStudent'])->name('api.students.snooze');
Route::post('/api/students/{id}/ban', [MerchController::class, 'banStudent'])->name('api.students.ban');
Route::post('/api/students/{id}/unban', [MerchController::class, 'unbanStudent'])->name('api.students.unban');

// Admin Message Buyer from Reservation Queue
Route::post('/api/reservations/{id}/message-buyer', [MerchController::class, 'messageBuyerFromReservation'])->name('api.reservations.message_buyer');

// Real-Time Online Payment Sandbox & PayMongo Test Mode Routes (GCash, Maya, Debit/Credit Card + Normal Camera QR Scan)
Route::post('/api/payment/sandbox/create', [PaymentSandboxController::class, 'createSession'])->name('api.payment.sandbox.create');
Route::get('/payment/sandbox/{token}', [PaymentSandboxController::class, 'showPortal'])->name('payment.sandbox.portal');
Route::get('/payment/sandbox/{token}/paymongo', [PaymentSandboxController::class, 'createPayMongoRedirect'])->name('payment.sandbox.paymongo');
Route::post('/api/payment/sandbox/{token}/step', [PaymentSandboxController::class, 'updateStep'])->name('api.payment.sandbox.step');
Route::post('/api/payment/sandbox/{token}/complete', [PaymentSandboxController::class, 'completePayment'])->name('api.payment.sandbox.complete');
Route::get('/api/payment/sandbox/{token}/status', [PaymentSandboxController::class, 'checkStatus'])->name('api.payment.sandbox.status');