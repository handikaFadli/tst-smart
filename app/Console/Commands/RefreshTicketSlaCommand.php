<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TicketSlaService;

class RefreshTicketSlaCommand extends Command
{
    protected $signature = 'ticket:sla-refresh';

    protected $description = 'Refresh SLA Ticket';

    public function handle(TicketSlaService $slaService)
    {
        $total = $slaService->refreshAllOpenTickets();

        $this->info("$total ticket diproses.");

        return self::SUCCESS;
    }
}
