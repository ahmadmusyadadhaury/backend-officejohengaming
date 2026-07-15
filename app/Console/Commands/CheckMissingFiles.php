<?php

namespace App\Console\Commands;

use App\Models\Mom;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CheckMissingFiles extends Command
{
    protected $signature = 'files:check';

    protected $description = 'Check all MOM files and report which ones are missing from disk';

    public function handle(): int
    {
        $moms = Mom::whereNotNull('file_path')->get();

        if ($moms->isEmpty()) {
            $this->info('Tidak ada MOM dengan file lampiran.');

            return 0;
        }

        $found = 0;
        $missing = 0;

        $this->newLine();
        $this->table(
            ['ID', 'File Path', 'Status'],
            $moms->map(fn ($mom) => [
                $mom->id,
                $mom->file_path,
                Storage::disk('public')->exists($mom->file_path) ? '✓ Ada' : '✗ HILANG',
            ])->toArray()
        );

        $found = $moms->filter(fn ($m) => Storage::disk('public')->exists($m->file_path))->count();
        $missing = $moms->count() - $found;

        $this->newLine();
        $this->info("Total: {$moms->count()} file | Ada: {$found} | Hilang: {$missing}");

        if ($missing > 0) {
            $this->warn("Upload folder 'storage/app/public/mom-files/' ke server via FTP/File Manager.");
        }

        return $missing > 0 ? 1 : 0;
    }
}
