<?php

use Illuminate\Support\Facades\Schedule;

// Jalankan setiap menit: generate sesi & selesaikan yang expired
Schedule::command('weekly:process')->everyMinute();

// Proses tagihan IPL Ruko: tidak diperlukan lagi — jatuh tempo dihitung otomatis via H-7
// Schedule::command('ipl:process')->dailyAt('00:00');
