<?php

namespace App\Imports;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KaryawanImport implements SkipsOnFailure, ToModel, WithChunkReading, WithHeadingRow
{
    use SkipsFailures;

    private int $successCount = 0;

    private int $skippedCount = 0;

    private array $skipped = [];

    private array $errors = [];

    private array $usedUsername = [];

    private array $usedNik = [];

    private Collection $teamsByName;

    private bool $allowAdmin;

    public function __construct(bool $allowAdmin = false)
    {
        $this->allowAdmin = $allowAdmin;
        $this->teamsByName = Team::where('is_active', true)
            ->get()
            ->keyBy(fn ($team) => mb_strtolower(trim($team->name)));
    }

    public function model(array $row)
    {
        $username = trim((string) ($row['username'] ?? ''));
        $nama = trim((string) ($row['nama'] ?? ''));
        $nik = trim((string) ($row['nik'] ?? ''));
        $tim = trim((string) ($row['tim'] ?? ''));
        $role = $this->mapRole((string) ($row['role'] ?? ''));
        $password = trim((string) ($row['password'] ?? '')) !== '' ? (string) $row['password'] : 'password';

        if ($username === '' && $nama === '') {
            return null;
        }

        if ($username === '') {
            $this->errors[] = "Baris '{$nama}': Username kosong.";

            return null;
        }

        if ($nama === '') {
            $this->errors[] = "Username '{$username}': Nama kosong.";

            return null;
        }

        if ($role === 'admin' && ! $this->allowAdmin) {
            $this->skippedCount++;
            $this->skipped[] = "Username '{$username}': role Admin hanya dapat dibuat oleh Admin Master — dilewati.";

            return null;
        }

        if (in_array($username, $this->usedUsername, true)) {
            $this->skippedCount++;
            $this->skipped[] = "Username '{$username}' duplikat dalam file — dilewati.";

            return null;
        }

        if (User::where('username', $username)->exists()) {
            $this->skippedCount++;
            $this->skipped[] = "Username '{$username}' sudah terdaftar — dilewati.";

            return null;
        }

        if ($nik !== '') {
            if (in_array($nik, $this->usedNik, true)) {
                $this->skippedCount++;
                $this->skipped[] = "NIK '{$nik}' (username '{$username}') duplikat dalam file — dilewati.";

                return null;
            }

            if (mb_strlen($nik) > 50) {
                $this->errors[] = "NIK '{$nik}' (username '{$username}') terlalu panjang (maks 50 karakter).";

                return null;
            }

            if (User::where('nik', $nik)->exists()) {
                $this->skippedCount++;
                $this->skipped[] = "NIK '{$nik}' (username '{$username}') sudah dipakai user lain — dilewati.";

                return null;
            }
        }

        $teamId = null;
        if ($role !== 'admin' && $tim !== '') {
            $team = $this->teamsByName[mb_strtolower($tim)] ?? null;
            if (! $team) {
                $this->errors[] = "Username '{$username}': tim '{$tim}' tidak ditemukan.";

                return null;
            }
            $teamId = $team->id;
        } elseif ($role === 'koordinator') {
            $this->errors[] = "Username '{$username}': Tim wajib diisi untuk role Koordinator.";

            return null;
        }

        $this->usedUsername[] = $username;
        if ($nik !== '') {
            $this->usedNik[] = $nik;
        }
        $this->successCount++;

        return new User([
            'name' => $nama,
            'username' => $username,
            'nik' => $nik ?: null,
            'password' => Hash::make($password),
            'role' => $role,
            'team_id' => $teamId,
            'is_active' => true,
        ]);
    }

    private function mapRole(string $value): string
    {
        return match (mb_strtolower(trim($value))) {
            'koordinator' => 'koordinator',
            'admin' => 'admin',
            default => 'user',
        };
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    public function getSkippedCount(): int
    {
        return $this->skippedCount;
    }

    public function getSkipped(): array
    {
        return $this->skipped;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
