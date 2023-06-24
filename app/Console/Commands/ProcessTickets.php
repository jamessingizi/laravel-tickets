<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class ProcessTickets extends Command
{
    protected $signature = 'ticket:process';
    protected $description = 'Command description';

    public function handle(): void
    {
        $tickets = Ticket::where('status', 0)
            ->orderBy('created_at')
            ->take(5)
            ->get();

        foreach ($tickets as $ticket) {
            $ticket->status = 1;
            $ticket->save();
        }

        $this->info(count($tickets) . ' ticket(s) processed successfully!');
    }
}
