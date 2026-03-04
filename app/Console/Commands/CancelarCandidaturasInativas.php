<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Candidatura;
use Carbon\Carbon;

class CancelarCandidaturasInativas extends Command
{
    protected $signature = 'candidaturas:encerrar-inativas';

    protected $description = 'Recusa automaticamente candidaturas inativas há 15 dias';

    public function handle()
    {
        $limite = Carbon::now()->subDays(15);

        $total = Candidatura::whereNotIn('status', ['aprovado', 'recusado'])
            ->where('updated_at', '<=', $limite)
            ->update([
                'status' => 'recusado'
            ]);

        $this->info("Candidaturas encerradas automaticamente: {$total}");
    }
}