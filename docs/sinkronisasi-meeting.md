# Panduan Sinkronisasi Jadwal Meeting (Untuk Website Lain)

Website lain (Laravel/PHP) dapat menampilkan jadwal meeting dari sistem ini
melalui API. Bagian ini hanya **membaca data (read-only)** — tidak mengubah
data meeting di sistem sumber.

---

## 1. Prasyarat di Sisi Sumber (sistem ini)

Server API harus bisa diakses dari device lain:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Lalu buka tunnel publik (di terminal terpisah):

```bash
ngrok http 8000
```

Catat URL publik (contoh saat ini): `https://icing-geriatric-idiom.ngrok-free.dev`.

> Catatan: URL ngrok gratis berubah setiap restart. Jika sudah di-hosting di
> server produksi, gunakan domain tersebut langsung.

Uji dari device lain:

```bash
curl -X POST https://icing-geriatric-idiom.ngrok-free.dev/api/auth/login \
  -H "Content-Type: application/json" \
  -d "{\"username\":\"admin\",\"password\":\"password\"}"
```

Respons berisi `token`. Uji ambil data:

```bash
curl https://icing-geriatric-idiom.ngrok-free.dev/api/meetings?month=2026-08 \
  -H "Authorization: Bearer <token>"
```

---

## 2. Langkah di Website Laravel (device lain)

### 2.1 Tambahkan konfigurasi di `.env`

```env
MEETING_API_URL=https://icing-geriatric-idiom.ngrok-free.dev
MEETING_API_USERNAME=admin
MEETING_API_PASSWORD=password
```

### 2.2 Buat service `app/Services/MeetingApiService.php`

```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MeetingApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) env('MEETING_API_URL', 'http://localhost:8000'), '/');
    }

    public function getMeetings(array $params = []): array
    {
        $key = 'meeting_api_meetings_'.md5(json_encode($params));

        return Cache::remember($key, now()->addMinutes(5), function () use ($params) {
            $response = Http::withToken($this->getToken())
                ->timeout(15)
                ->get($this->baseUrl.'/api/meetings', $params);

            if ($response->failed()) {
                throw new \RuntimeException('Gagal mengambil data meeting: '.$response->status());
            }

            $payload = $response->json();

            return isset($payload['data']) ? $payload['data'] : $payload;
        });
    }

    protected function getToken(): string
    {
        return Cache::remember('meeting_api_token', now()->addDays(29), function () {
            $response = Http::timeout(15)->post($this->baseUrl.'/api/auth/login', [
                'username' => env('MEETING_API_USERNAME'),
                'password' => env('MEETING_API_PASSWORD'),
            ]);

            if ($response->failed()) {
                throw new \RuntimeException('Login API meeting gagal: '.$response->status());
            }

            return $response->json('token');
        });
    }
}
```

> Token dari sistem sumber berlaku 30 hari. Cache di atas diset 29 hari agar
> otomatis login ulang sebelum kadaluwarsa. Jika `MEETING_API_URL` berubah
> (ngrok restart), jalankan `php artisan cache:clear` pada website ini.
>
> Service di atas sudah otomatis membongkar `data` dari respons ber-paginasi,
> sehingga `$meetings` di view selalu berupa array daftar meeting.

### 2.3 Buat controller `app/Http/Controllers/MeetingScheduleController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Services\MeetingApiService;
use Illuminate\Http\Request;

class MeetingScheduleController extends Controller
{
    public function __invoke(Request $request, MeetingApiService $api)
    {
        $month = $request->get('month', now()->format('Y-m'));

        try {
            $meetings = $api->getMeetings([
                'month' => $month,
                'per_page' => 100,
            ]);
        } catch (\Throwable $e) {
            $meetings = [];
        }

        return view('meeting-schedule', [
            'meetings' => $meetings,
            'month' => $month,
        ]);
    }
}
```

### 2.4 Daftarkan route di `routes/web.php`

```php
use App\Http\Controllers\MeetingScheduleController;

Route::get('/jadwal-meeting', MeetingScheduleController::class)->name('meeting-schedule');
```

### 2.5 Buat view `resources/views/meeting-schedule.blade.php`

```blade
@extends('layouts.app') {{-- sesuaikan dengan layout website Anda --}}

@section('title', 'Jadwal Meeting')
@section('content')
    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Jadwal Meeting</h1>

        <form method="GET" class="mb-4">
            <input type="month" name="month" value="{{ $month }}"
                   class="border rounded px-3 py-2">
            <button type="submit" class="bg-blue-600 text-white rounded px-4 py-2">Lihat</button>
        </form>

        @if (empty($meetings))
            <p class="text-gray-500">Tidak ada data meeting.</p>
        @else
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-3 py-2 text-left">Judul</th>
                        <th class="border px-3 py-2 text-left">Tanggal</th>
                        <th class="border px-3 py-2 text-left">Jam</th>
                        <th class="border px-3 py-2 text-left">Ruangan</th>
                        <th class="border px-3 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($meetings as $m)
                        <tr>
                            <td class="border px-3 py-2">{{ $m['title'] }}</td>
                            <td class="border px-3 py-2">{{ $m['meeting_date'] }}</td>
                            <td class="border px-3 py-2">{{ $m['start_time'] }} - {{ $m['end_time'] }}</td>
                            <td class="border px-3 py-2">{{ $m['room']['name'] ?? '-' }}</td>
                            <td class="border px-3 py-2">
                                <span class="px-2 py-1 rounded text-xs
                                    {{ $m['status'] === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $m['status'] === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $m['status'] === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $m['status'] === 'cancelled' ? 'bg-gray-200 text-gray-600' : '' }}">
                                    {{ $m['status'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
```

---

## 3. Struktur Respons API

`GET {MEETING_API_URL}/api/meetings` (tanpa `per_page`):

```json
[
  {
    "id": 1,
    "title": "Rapat Mingguan",
    "why": "...",
    "what": "...",
    "how_expected": "...",
    "requester": { "id": 3, "name": "Koordinator" },
    "team": { "id": 1, "name": "Tim IT" },
    "room": { "id": 1, "name": "Ruang Meeting A", "location": "Lt.2" },
    "meeting_date": "2026-08-04",
    "start_time": "09:00:00",
    "end_time": "10:00:00",
    "status": "approved",
    "queue_position": null,
    "reject_reason": null,
    "is_weekly": false,
    "assets": [],
    "participants": [],
    "mom": null
  }
]
```

Filter yang tersedia: `date_from`, `date_to`, `month` (`YYYY-MM`), `status`,
`search`, `per_page`.

---

## 4. Troubleshooting

| Masalah | Solusi |
|---------|--------|
| 401 Unauthorized | Cek `MEETING_API_USERNAME` / `MEETING_API_PASSWORD` di `.env` website ini. |
| 500 saat login | Pastikan `MEETING_API_URL` benar & server sumber jalan. |
| Data kosong setelah ngrok restart | URL ngrok berubah → update `.env`, lalu `php artisan cache:clear`. |
| `cURL error` | Pastikan server sumber jalan (`php artisan serve`) dan device lain bisa ping URL ngrok. |
