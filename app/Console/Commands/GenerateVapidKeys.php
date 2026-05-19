<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateVapidKeys extends Command
{
    protected $signature = 'vapid:generate';
    protected $description = 'Generate VAPID keys untuk Web Push notification';

    public function handle(): void
    {
        $keys = $this->generateKeys();

        if (!$keys) {
            $this->error('Gagal generate VAPID keys. Pastikan ekstensi openssl dan gmp/bcmath tersedia.');
            return;
        }

        $this->saveToEnv($keys['publicKey'], $keys['privateKey']);

        $this->info('VAPID keys berhasil digenerate dan disimpan ke .env!');
        $this->line("Public Key:  {$keys['publicKey']}");
        $this->line("Private Key: {$keys['privateKey']}");
    }

    private function generateKeys(): ?array
    {
        // Coba via minishlink/web-push library (butuh gmp)
        if (class_exists(\Minishlink\WebPush\VAPID::class)) {
            try {
                return \Minishlink\WebPush\VAPID::createVapidKeys();
            } catch (\Throwable $e) {
                $this->warn('Metode library gagal, coba fallback openssl...');
            }
        }

        // Fallback: generate via OpenSSL langsung
        if (!extension_loaded('openssl')) {
            return null;
        }

        $configPath = null;
        if (PHP_OS_FAMILY === 'Windows') {
            $phpDir = PHP_CONFIG_FILE_PATH;
            $candidates = [
                $phpDir . '\\extras\\ssl\\openssl.cnf',
                PHP_BINARY . '\\..\\extras\\ssl\\openssl.cnf',
                'C:\\laragon\\bin\\php\\php-8.4.12-nts-Win32-vs17-x64\\extras\\ssl\\openssl.cnf',
            ];
            foreach ($candidates as $candidate) {
                if (file_exists($candidate)) {
                    $configPath = $candidate;
                    break;
                }
            }
        }

        $keyConfig = ['config' => $configPath];
        $key = @openssl_pkey_new([
            'private_key_type' => OPENSSL_KEYTYPE_EC,
            'curve_name' => 'prime256v1',
            'config' => $configPath,
        ]);

        if (!$key) {
            return null;
        }

        $details = @openssl_pkey_get_details($key);
        if (!$details || !isset($details['ec']['x'], $details['ec']['y'], $details['ec']['d'])) {
            return null;
        }

        // Koordinat EC P-256 harus 32 byte — ambil 32 byte terakhir
        $x = substr(str_pad($details['ec']['x'], 32, "\0", STR_PAD_LEFT), -32);
        $y = substr(str_pad($details['ec']['y'], 32, "\0", STR_PAD_LEFT), -32);
        $d = substr(str_pad($details['ec']['d'], 32, "\0", STR_PAD_LEFT), -32);

        $pubRaw = $x . $y;
        $privRaw = $d;

        return [
            'publicKey'  => $this->base64url($pubRaw),
            'privateKey' => $this->base64url($privRaw),
        ];
    }

    private function base64url(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function saveToEnv(string $publicKey, string $privateKey): void
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            $this->error('.env file tidak ditemukan!');
            return;
        }

        $content = file_get_contents($envPath);
        $subject = 'mailto:admin@meetingroom.johengaming.store';

        $replacements = [
            'VAPID_PUBLIC_KEY'  => $publicKey,
            'VAPID_PRIVATE_KEY' => $privateKey,
            'VAPID_SUBJECT'     => $subject,
        ];

        foreach ($replacements as $key => $value) {
            $pattern = '/^' . preg_quote($key, '/') . '=.*/m';
            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, $key . '=' . $value, $content);
            } else {
                $content .= "\n" . $key . '=' . $value;
            }
        }

        file_put_contents($envPath, $content);
    }
}
