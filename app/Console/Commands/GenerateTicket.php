<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class GenerateTicket extends Command
{
    protected $signature = 'ticket:generate';
    protected $description = 'Generate a ticker with user data';

    public function handle(): void
    {

        $ticket = new Ticket;
        $ticket->subject = fake()->sentence;
        $ticket->content = fake()->paragraph;
        $ticket->name = fake()->name;
        $ticket->email = fake()->email;
        $ticket->status = 0;
        $ticket->save();

        $this->info('Ticket generated successfully!');
    }
}
