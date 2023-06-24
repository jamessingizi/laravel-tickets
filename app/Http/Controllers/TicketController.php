<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function openTickets(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 10);
        $tickets = Ticket::where('status', 0)
            ->orderBy('created_at')
            ->paginate($perPage);
        return response()->json($tickets, 200);
    }

    public function closedTickets(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 10);
        $tickets = Ticket::where('status', 1)
            ->orderBy('created_at')
            ->paginate($perPage);
        return response()->json($tickets, 200);
    }

    public function userTickets(Request $request, $email): JsonResponse
    {
        $perPage = $request->query('per_page', 10);
        $tickets = Ticket::where('email', $email)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        return response()->json($tickets, 200);
    }

    public function stats(): JsonResponse
    {
        $totalTickets = Ticket::count();
        $totalUnprocessedTickets = Ticket::where('status', 0)->count();

        $userWithMostTickets = Ticket::select('name', 'email', DB::raw('count(*) as total'))
            ->groupBy('email', 'name')
            ->orderByDesc('total')
            ->first();

        $lastProcessedTicketTime = Ticket::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->value('created_at');

        return response()->json([
            'total_tickets' => $totalTickets,
            'total_unprocessed_tickets' => $totalUnprocessedTickets,
            'user_with_most_tickets' => $userWithMostTickets,
            'last_processed_ticket_time' => $lastProcessedTicketTime,
        ], 200);
    }

}
