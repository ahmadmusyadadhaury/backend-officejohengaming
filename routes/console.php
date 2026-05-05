<?php

use Illuminate\Support\Facades\Schedule;

// Jalankan setiap menit: generate sesi & selesaikan yang expired
Schedule::command('weekly:process')->everyMinute();
