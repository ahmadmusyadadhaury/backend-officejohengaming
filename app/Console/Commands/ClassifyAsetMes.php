<?php

namespace App\Console\Commands;

use App\Models\AsetMes;
use Illuminate\Console\Command;

class ClassifyAsetMes extends Command
{
    protected $signature = 'aset-mes:classify
        {--dry-run : Tampilkan pratinjau tanpa menyimpan perubahan}';

    protected $description = 'Pindahkan aset MES lama ke kategori putra/putri berdasarkan kata kunci di kolom keterangan';

    private const PUTRI_KEYWORDS = ['putri', 'perempuan', 'wanita'];

    private const PUTRA_KEYWORDS = ['putra', 'laki', 'pria'];

    public function handle(): int
    {
        $rows = AsetMes::select('id', 'nama_aset', 'kategori', 'keterangan')
            ->whereNotNull('keterangan')
            ->orderBy('id')
            ->get();

        $total = $rows->count();
        $moved = 0;
        $ambiguous = 0;
        $alreadyCorrect = 0;
        $dryRun = $this->option('dry-run');

        $this->line('');
        $this->info($dryRun ? 'PRATINJAU (dry-run) — tidak ada data yang diubah.' : 'Memproses klasifikasi aset MES...');
        $this->line('');

        foreach ($rows as $asset) {
            $target = $this->classify($asset->keterangan);

            if ($target === null) {
                $ambiguous++;

                continue;
            }

            if ($target === $asset->kategori) {
                $alreadyCorrect++;

                continue;
            }

            $moved++;
            $this->line(sprintf(
                '  [%d] %s — ket: "%s"  %s  =>  %s',
                $asset->id,
                $asset->nama_aset,
                $asset->keterangan,
                $this->badge($asset->kategori),
                $this->badge($target),
            ));

            if (! $dryRun) {
                AsetMes::where('id', $asset->id)->update(['kategori' => $target]);
            }
        }

        $this->line('');
        $this->info(sprintf('Total baris dianalisis: %d', $total));
        $this->info(sprintf('  Sudah benar        : %d', $alreadyCorrect));
        $this->info(sprintf('  Akan/dipindahkan   : %d', $moved));
        $this->info(sprintf('  Ambigu (dibiarkan) : %d', $ambiguous));

        if ($ambiguous > 0) {
            $this->warn('  Baris ambigu tidak diubah — cek manual di menu Aset MES.');
        }

        if ($dryRun && $moved > 0) {
            $this->warn('  Jalankan tanpa --dry-run untuk menerapkan perubahan.');
        }

        return self::SUCCESS;
    }

    private function classify(?string $keterangan): ?string
    {
        if ($keterangan === null || trim($keterangan) === '') {
            return null;
        }

        $text = mb_strtolower($keterangan);

        foreach (self::PUTRI_KEYWORDS as $keyword) {
            if (str_contains($text, $keyword)) {
                return 'putri';
            }
        }

        foreach (self::PUTRA_KEYWORDS as $keyword) {
            if (str_contains($text, $keyword)) {
                return 'putra';
            }
        }

        return null;
    }

    private function badge(string $kategori): string
    {
        return $kategori === 'putri' ? 'Putri' : 'Putra';
    }
}
