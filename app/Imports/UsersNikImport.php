<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersNikImport implements SkipsOnFailure, ToModel, WithChunkReading, WithHeadingRow
{
    use SkipsFailures;

    private int $successCount = 0;

    private array $errors = [];

    private array $usedNik = [];

    public function model(array $row)
    {
        $username = trim((string) ($row['username'] ?? ''));
        $nik = trim((string) ($row['nik'] ?? ''));

        if ($username === '' && $nik === '') {
            return null;
        }

        if ($username === '') {
            $this->errors[] = "NIK '{$nik}' gagal diimport: baris tidak memiliki username.";

            return null;
        }

        $user = User::where('username', $username)->first();
        if (! $user) {
            $this->errors[] = "NIK '{$nik}' gagal diimport: username '{$username}' tidak ditemukan.";

            return null;
        }

        if ($nik === '') {
            $this->errors[] = "NIK gagal diimport untuk username '{$username}': kolom NIK kosong.";

            return null;
        }

        if (mb_strlen($nik) > 50) {
            $this->errors[] = "NIK untuk username '{$username}' terlalu panjang (maks 50 karakter).";

            return null;
        }

        if (in_array($nik, $this->usedNik, true)) {
            $this->errors[] = "NIK '{$nik}' untuk username '{$username}' duplikat dalam file.";

            return null;
        }

        if (User::where('nik', $nik)->where('id', '!=', $user->id)->exists()) {
            $this->errors[] = "NIK '{$nik}' untuk username '{$username}' sudah digunakan user lain.";

            return null;
        }

        $this->usedNik[] = $nik;

        $user->update(['nik' => $nik]);
        $this->successCount++;

        return null;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
