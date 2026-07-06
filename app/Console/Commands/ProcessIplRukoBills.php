<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProcessIplRukoBills extends Command
{
    protected $signature = 'ipl:process';

    protected $description = 'Ubah status IPL Ruko dari pending menjadi jatuh tempo saat tanggalnya tiba';

    public function handle(): void
    {
        // Tidak diperlukan lagi — status jatuh tempo dihitung otomatis
        // berdasarkan tanggal jatuh tempo (H-7) di setiap query.
        $this->info('Status jatuh tempo dihitung otomatis berdasarkan tanggal (H-7).');
    }
}
