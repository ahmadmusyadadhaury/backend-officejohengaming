<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeralatanKantor;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = Vehicle::orderBy('created_at', 'desc')->get();

        $statusFilter = $request->get('status', 'all');

        $filtered = $vehicles->filter(function ($v) use ($statusFilter) {
            if ($statusFilter === 'all') {
                return true;
            }

            return $v->status_pajak === $statusFilter;
        });

        $peralatanKendaraan = $this->peralatanKendaraan();

        $search = trim((string) $request->get('search', ''));

        if ($search !== '') {
            $needle = strtolower($search);
            $filtered = $filtered->filter(function ($v) use ($needle) {
                $text = strtolower(
                    ($v->nama_kendaraan ?? '').' '.
                    ($v->plat_nomor ?? '').' '.
                    ($v->merk_tipe ?? '').' '.
                    ($v->nomor_rangka ?? '').' '.
                    ($v->pic ?? '')
                );
                return str_contains($text, $needle);
            })->values();

            $peralatanKendaraan = $peralatanKendaraan->filter(function ($p) use ($needle) {
                $text = strtolower(
                    ($p->nama_kendaraan ?? '').' '.
                    ($p->merk_tipe ?? '').' '.
                    ($p->plat_nomor ?? '')
                );
                return str_contains($text, $needle);
            })->values();
        }

        $stats = [
            'total' => $vehicles->count() + $peralatanKendaraan->count(),
            'pajak_aktif' => $vehicles->filter(fn ($v) => $v->status_pajak === 'aktif')->count(),
            'segera_habis' => $vehicles->filter(fn ($v) => $v->status_pajak === 'segera_habis')->count(),
            'jatuh_tempo' => $vehicles->filter(fn ($v) => $v->status_pajak === 'jatuh_tempo')->count(),
            'pajak_mati' => $vehicles->filter(fn ($v) => $v->status_pajak === 'mati')->count(),
        ];

        $vehiclesJson = $filtered->values()->map(function ($v) {
            return [
                'id' => $v->id,
                'nama_kendaraan' => $v->nama_kendaraan,
                'jenis_kendaraan' => $v->jenis_kendaraan,
                'merk_tipe' => $v->merk_tipe,
                'plat_nomor' => $v->plat_nomor,
                'tahun' => $v->tahun,
                'warna' => $v->warna,
                'nomor_rangka' => $v->nomor_rangka,
                'nomor_mesin' => $v->nomor_mesin,
                'foto' => $v->foto ? route('files.show', $v->foto) : null,
                'pajak_tahunan' => $v->pajak_tahunan?->format('d/m/Y'),
                'pajak_5_tahun' => $v->pajak_5_tahun?->format('d/m/Y'),
                'kepemilikan_status' => $v->kepemilikan_status,
                'biaya_kendaraan' => (int) $v->biaya_kendaraan,
                'biaya_pajak_tahunan' => $v->biaya_pajak_tahunan ? (int) $v->biaya_pajak_tahunan : null,
                'biaya_pajak_5_tahun' => $v->biaya_pajak_5_tahun ? (int) $v->biaya_pajak_5_tahun : null,
                'pic' => $v->pic,
                'jabatan' => $v->jabatan,
                'keperluan' => $v->keperluan,
                'status_pajak' => $v->status_pajak,
                'hari_pajak' => $v->hari_pajak,
                'sumber' => 'vehicle',
            ];
        })->concat($statusFilter === 'all' ? $peralatanKendaraan->map(fn ($p) => (array) $p) : collect());

        $alertVehicles = $vehicles->filter(fn ($v) => in_array($v->status_pajak, ['segera_habis', 'jatuh_tempo', 'mati']));
        $alertJson = $alertVehicles->values()->map(fn ($v) => [
            'id' => $v->id,
            'nama_kendaraan' => $v->nama_kendaraan,
            'plat_nomor' => $v->plat_nomor,
            'jenis_kendaraan' => $v->jenis_kendaraan,
            'pajak_tahunan' => $v->pajak_tahunan?->format('d/m/Y'),
            'pajak_5_tahun' => $v->pajak_5_tahun?->format('d/m/Y'),
            'status_pajak' => $v->status_pajak,
            'hari_pajak' => $v->hari_pajak,
        ]);

        $showAll = $request->boolean('show_all');

        $merged = $filtered->values()->concat($statusFilter === 'all' ? $peralatanKendaraan : collect())->values();

        $perPage = $showAll ? max($merged->count(), 1) : 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedItems = $merged->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedVehicles = new LengthAwarePaginator(
            $pagedItems,
            $merged->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        return view('admin.vehicles.index', [
            'vehicles' => $paginatedVehicles,
            'vehiclesJson' => $vehiclesJson,
            'stats' => $stats,
            'statusFilter' => $statusFilter,
            'alertVehicles' => $alertVehicles,
            'alertJson' => $alertJson,
            'peralatanCount' => $peralatanKendaraan->count(),
            'showAll' => $showAll,
            'search' => $search,
        ]);
    }

    protected function peralatanKendaraan(): Collection
    {
        return PeralatanKantor::where('sub_kategori', 'Kendaraan')
            ->orderBy('kode_aset')
            ->get()
            ->map(function ($p) {
                $keterangan = collect([
                    $p->kode_aset ? 'Kode Aset: '.$p->kode_aset : null,
                    $p->lokasi_unit ? 'Lokasi: '.$p->lokasi_unit : null,
                    $p->ruangan ? 'Ruang: '.$p->ruangan : null,
                    $p->kondisi ? 'Kondisi: '.$p->kondisi : null,
                    $p->keterangan ?: null,
                ])->filter()->implode(' • ');

                return (object) [
                    'id' => 'pk-'.$p->id,
                    'nama_kendaraan' => $p->nama_barang,
                    'jenis_kendaraan' => 'Motor',
                    'merk_tipe' => $p->detail ?: null,
                    'plat_nomor' => null,
                    'tahun' => $p->pengadaan_tahun,
                    'warna' => null,
                    'nomor_rangka' => null,
                    'nomor_mesin' => null,
                    'foto' => $p->foto ? route('files.show', $p->foto) : null,
                    'pajak_tahunan' => null,
                    'pajak_5_tahun' => null,
                    'kepemilikan_status' => $p->milik,
                    'biaya_kendaraan' => null,
                    'biaya_pajak_tahunan' => null,
                    'biaya_pajak_5_tahun' => null,
                    'pic' => $p->pic,
                    'jabatan' => $p->jabatan,
                    'keperluan' => $keterangan,
                    'status_pajak' => null,
                    'hari_pajak' => null,
                    'sumber' => 'peralatan',
                    'kode_aset' => $p->kode_aset,
                    'lokasi_unit' => $p->lokasi_unit,
                    'ruangan' => $p->ruangan,
                    'kondisi' => $p->kondisi,
                ];
            });
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'jenis_kendaraan' => 'required|string|max:255',
            'merk_tipe' => 'nullable|string|max:255',
            'plat_nomor' => 'required|string|max:20|unique:vehicles,plat_nomor',
            'tahun' => 'required|integer|min:1900|max:'.(now()->year + 1),
            'warna' => 'nullable|string|max:255',
            'nomor_rangka' => 'nullable|string|max:255',
            'nomor_mesin' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'pajak_tahunan' => 'required|date',
            'pajak_5_tahun' => 'required|date',
            'kepemilikan_status' => 'required|string|max:255',
            'biaya_kendaraan' => 'required|numeric|min:0',
            'pic' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'keperluan' => 'nullable|string',
            'biaya_pajak_tahunan' => 'nullable|numeric|min:0',
            'biaya_pajak_5_tahun' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('vehicles', 'public');
        }

        Vehicle::create($data);

        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'jenis_kendaraan' => 'required|string|max:255',
            'merk_tipe' => 'nullable|string|max:255',
            'plat_nomor' => 'required|string|max:20|unique:vehicles,plat_nomor,'.$vehicle->id,
            'tahun' => 'required|integer|min:1900|max:'.(now()->year + 1),
            'warna' => 'nullable|string|max:255',
            'nomor_rangka' => 'nullable|string|max:255',
            'nomor_mesin' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'pajak_tahunan' => 'required|date',
            'pajak_5_tahun' => 'required|date',
            'kepemilikan_status' => 'required|string|max:255',
            'biaya_kendaraan' => 'required|numeric|min:0',
            'pic' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'keperluan' => 'nullable|string',
            'biaya_pajak_tahunan' => 'nullable|numeric|min:0',
            'biaya_pajak_5_tahun' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('foto')) {
            if ($vehicle->foto) {
                Storage::disk('public')->delete($vehicle->foto);
            }
            $data['foto'] = $request->file('foto')->store('vehicles', 'public');
        }

        $vehicle->update($data);

        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil dihapus.');
    }

    public function updateStatus(Request $request, Vehicle $vehicle)
    {
        $status = $request->validate(['status' => 'required|in:aktif,jatuh_tempo,segera_habis,mati'])['status'];

        $vehicle->pajak_tahunan = match ($status) {
            'aktif' => now()->addYear(),
            'jatuh_tempo' => now()->addDays(5),
            'segera_habis' => now()->addDays(1),
            'mati' => now()->subDay(),
        };
        $vehicle->save();

        return response()->json(['success' => true, 'status' => $status]);
    }
}
