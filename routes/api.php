<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('tickets/open', [TicketController::class, 'openTickets']);
Route::get('tickets/closed', [TicketController::class, 'closedTickets']);
Route::get('users/{email}/tickets', [TicketController::class, 'userTickets']);
Route::get('stats', [TicketController::class, 'stats']);

