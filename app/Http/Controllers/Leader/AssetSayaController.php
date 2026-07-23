<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\AsetMes;
use App\Models\AsetTim;
use App\Models\DigitalAsset;
use App\Models\PeralatanKantor;
use App\Models\SimCard;
use App\Models\SosialMedia;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AssetSayaController extends Controller
{
    public function index(Request $request)
    {
        $userName = auth()->user()->name;
        $userId = auth()->id();

        $assets = $this->getMyAssets($userName, $userId);

        // Search
        if ($search = $request->input('search')) {
            $assets = $assets->filter(fn ($a) => str_contains(strtolower($a['nama_aset']), strtolower($search))
                || str_contains(strtolower($a['kode_aset'] ?? ''), strtolower($search))
                || str_contains(strtolower($a['pic']), strtolower($search))
                || str_contains(strtolower($a['kategori']), strtolower($search))
            );
        }

        // Filter by kategori
        if ($kategori = $request->input('kategori')) {
            $assets = $assets->filter(fn ($a) => $a['kategori'] === $kategori);
        }

        // Sort
        $sortField = $request->input('sort', 'created_at');
        $sortDir = $request->input('dir', 'desc');
        $assets = $assets->sortBy($sortField, SORT_REGULAR, $sortDir === 'asc')->values();

        // Pagination
        $perPage = 15;
        $page = $request->input('page', 1);
        $total = $assets->count();
        $items = $assets->slice(($page - 1) * $perPage, $perPage);
        $paginator = new LengthAwarePaginator($items, $total, $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        // Stats
        $kategoriCounts = $assets->groupBy('kategori')->map(fn ($g) => $g->count());
        $allKategoris = ['Kendaraan', 'Digital', 'Sosial Media', 'SIM Card', 'Peralatan Kantor', 'Aset MES', 'Aset TIM'];

        return view('leader.asset-saya.index', compact('paginator', 'assets', 'kategoriCounts', 'allKategoris'));
    }

    private function getMyAssets(string $userName, int $userId): Collection
    {
        $assets = collect();

        // Kendaraan — pic = string name, no is_active column
        $assets = $assets->merge(
            Vehicle::where('pic', $userName)->get()->map(fn ($v) => $this->mapItem($v, 'Kendaraan', $v->nama_kendaraan, $v->plat_nomor, '-', $v->pic, $v->jabatan, null, $v->created_at, ucfirst(str_replace('_', ' ', $v->status_pajak))))
        );

        // Digital — pic = string name
        $assets = $assets->merge(
            DigitalAsset::where('pic', $userName)->get()->map(fn ($d) => $this->mapItem($d, 'Digital', $d->nama_aset, $d->email, '-', $d->pic, $d->jabatan, null, $d->created_at, $d->is_active ? 'Aktif' : 'Tidak Aktif'))
        );

        // Sosial Media — pic = string name
        $assets = $assets->merge(
            SosialMedia::where('pic', $userName)->get()->map(fn ($s) => $this->mapItem($s, 'Sosial Media', $s->nama, $s->username, $s->platform, $s->pic, '-', null, $s->created_at, $s->status === 'aktif' ? 'Aktif' : 'Nonaktif'))
        );

        // SIM Card — pic = string name
        $assets = $assets->merge(
            SimCard::where('pic', $userName)->get()->map(fn ($s) => $this->mapItem($s, 'SIM Card', $s->nomor_sim_card, $s->nomor_sim_card, '-', $s->pic, $s->jabatan, $s->atasan, $s->created_at, $s->status_kartu ? 'Aktif' : 'Nonaktif'))
        );

        // Peralatan Kantor — pic = string name (nullable)
        $assets = $assets->merge(
            PeralatanKantor::where('pic', $userName)->get()->map(fn ($p) => $this->mapItem($p, 'Peralatan Kantor', $p->nama_barang, $p->kode_aset ?? '-', $p->lokasi_unit, $p->pic ?? '-', $p->jabatan ?? '-', $p->atasan ?? '-', $p->created_at, ucfirst($p->kondisi)))
        );

        // Aset MES — penanggung_jawab = user ID
        $assets = $assets->merge(
            AsetMes::where('penanggung_jawab', $userId)->get()->map(fn ($m) => $this->mapItem($m, 'Aset MES', $m->nama_aset, '-', '-', $m->penanggungJawab?->name ?? ($m->pic ?? '-'), $m->jabatan ?? '-', null, $m->created_at, $m->is_active ? 'Aktif' : 'Tidak Aktif'))
        );

        // Aset TIM — penanggung_jawab = user ID
        $assets = $assets->merge(
            AsetTim::where('penanggung_jawab', $userId)->get()->map(fn ($t) => $this->mapItem($t, 'Aset TIM', $t->nama_aset, '-', $t->tim ?? '-', $t->penanggungJawab?->name ?? ($t->pic ?? '-'), $t->jabatan ?? '-', null, $t->created_at, $t->is_active ? 'Aktif' : 'Tidak Aktif'))
        );

        return $assets;
    }

    private function mapItem($model, string $kategori, string $namaAset, string $kodeAset, string $lokasi, string $pic, string $jabatan, ?string $atasan, $createdAt, string $status): array
    {
        return [
            'id' => $model->id,
            'kategori' => $kategori,
            'nama_aset' => $namaAset,
            'kode_aset' => $kodeAset,
            'lokasi' => $lokasi,
            'pic' => $pic,
            'jabatan' => $jabatan,
            'atasan' => $atasan ?? '-',
            'created_at' => $createdAt,
            'status' => $status,
        ];
    }
}
