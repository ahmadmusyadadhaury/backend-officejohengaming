<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DataExport;
use App\Http\Controllers\Controller;
use App\Models\AsetRuko;
use App\Models\Asset;
use App\Models\DigitalAsset;
use App\Models\ElectricityTokenReading;
use App\Models\Meeting;
use App\Models\Payment;
use App\Models\PembayaranAsetDigital;
use App\Models\PembayaranIplRuko;
use App\Models\PeralatanKantor;
use App\Models\Room;
use App\Models\SimCard;
use App\Models\Team;
use App\Models\TokenPayment;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\WifiPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $type = $request->query('type');
        $jenis = $request->query('jenis');
        $filter = $request->query('filter', 'all');

        $exports = [
            'assets' => fn () => $this->assetsExport($filter),
            'users' => fn () => $this->usersExport($filter),
            'admins' => fn () => $this->adminsExport($filter),
            'teams' => fn () => $this->teamsExport($filter),
            'rooms' => fn () => $this->roomsExport($filter),
            'meetings' => fn () => $this->meetingsExport($request),
            'vehicles' => fn () => $this->vehiclesExport($filter),
            'digital-assets' => fn () => $this->digitalAssetsExport($filter),
            'sim-cards' => fn () => $this->simCardsExport($filter),
            'peralatan-kantor' => fn () => $this->peralatanKantorExport($filter),
            'ruko' => fn () => $this->rukoExport($filter),
            'pembayaran' => fn () => $this->pembayaranExport($jenis, $filter),
            'token-readings' => fn () => $this->tokenReadingsExport($request),
            'token-topups' => fn () => $this->tokenTopupsExport($request),
        ];

        if (! isset($exports[$type])) {
            return redirect()->back()->with('error', 'Tipe export tidak valid.');
        }

        return $exports[$type]();
    }

    protected function assetsExport($filter = 'all')
    {
        $data = Asset::orderBy('created_at', 'desc')->get()->map(fn ($a) => [
            'Nama Aset' => $a->nama_aset,
            'Kategori' => $a->kategori,
            'Lokasi' => $a->lokasi,
            'Jumlah' => $a->jumlah,
            'Kondisi' => $a->kondisi,
            'Keterangan' => $a->keterangan ?? '-',
        ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Aset', 'Aset'),
            'Data_Aset.xlsx'
        );
    }

    protected function usersExport($filter = 'all')
    {
        $data = User::where('role', 'user')->orderBy('name')->get()->map(fn ($u) => [
            'Nama' => $u->name,
            'Email' => $u->email,
            'Username' => $u->username,
            'Role' => $u->role,
            'Aktif' => $u->is_active ? 'Ya' : 'Tidak',
        ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Akun Karyawan', 'Karyawan'),
            'Data_Karyawan.xlsx'
        );
    }

    protected function adminsExport($filter = 'all')
    {
        $data = User::whereIn('role', ['admin', 'head_of_store', 'gm', 'hr', 'ceo'])
            ->orderBy('name')->get()->map(fn ($u) => [
                'Nama' => $u->name,
                'Email' => $u->email,
                'Username' => $u->username,
                'Role' => $u->role,
                'Aktif' => $u->is_active ? 'Ya' : 'Tidak',
            ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Akun Admin', 'Admin'),
            'Data_Admin.xlsx'
        );
    }

    protected function teamsExport($filter = 'all')
    {
        $data = Team::orderBy('name')->get()->map(fn ($t) => [
            'Nama Tim' => $t->name,
            'Deskripsi' => $t->description ?? '-',
            'Dibuat' => $t->created_at->format('d/m/Y'),
        ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Tim', 'Tim'),
            'Data_Tim.xlsx'
        );
    }

    protected function roomsExport($filter = 'all')
    {
        $data = Room::orderBy('name')->get()->map(fn ($r) => [
            'Nama Ruangan' => $r->name,
            'Lokasi' => $r->location ?? '-',
            'Kapasitas' => $r->capacity,
            'Deskripsi' => $r->description ?? '-',
        ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Ruangan', 'Ruangan'),
            'Data_Ruangan.xlsx'
        );
    }

    protected function meetingsExport($request)
    {
        $meetingMonth = $request->get('meeting_month', now()->format('Y-m'));
        $startDate = Carbon::parse($meetingMonth.'-01')->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $query = Meeting::with(['requester', 'room', 'team'])
            ->whereBetween('meeting_date', [$startDate, $endDate]);

        $statusLabelMap = [
            'pending' => 'Menunggu Review', 'approved' => 'Disetujui', 'rejected' => 'Ditolak',
            'confirmed' => 'Dikonfirmasi', 'cancelled' => 'Dibatalkan',
            'in_progress' => 'Berlangsung', 'completed' => 'Selesai',
        ];

        $data = $query->orderBy('meeting_date', 'desc')->get()->values()->map(fn ($m, $i) => [
            'No' => $i + 1,
            'Judul' => $m->title,
            'Tanggal' => $m->meeting_date->format('d/m/Y'),
            'Waktu' => substr($m->start_time, 0, 5).' - '.substr($m->end_time, 0, 5),
            'Ruangan' => $m->room?->name ?? '-',
            'Pemohon' => $m->requester?->name ?? '-',
            'Tim' => $m->team?->name ?? '-',
            'Status' => $statusLabelMap[$m->status] ?? $m->status,
            'Antrian' => $m->queue_position ? 'Antrian ke-'.$m->queue_position : ($m->status === 'completed' ? 'Selesai' : ($m->status === 'in_progress' ? 'Berlangsung' : '-')),
        ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Meeting', 'Meeting'),
            'Data_Meeting.xlsx'
        );
    }

    protected function vehiclesExport($filter = 'all')
    {
        $query = Vehicle::orderBy('nama_kendaraan');
        if ($filter !== 'all') {
            $query->where('status_pajak', $filter);
        }
        $data = $query->get()->map(fn ($v) => [
            'Nama Kendaraan' => $v->nama_kendaraan,
            'Nomor Polisi' => $v->plat_nomor ?? '-',
            'Jenis Kendaraan' => $v->jenis_kendaraan,
            'Merk / Tipe' => $v->merk_tipe ?? '-',
            'Tahun' => $v->tahun,
            'Warna' => $v->warna ?? '-',
            'Nomor Rangka' => $v->nomor_rangka ?? '-',
            'Nomor Mesin' => $v->nomor_mesin ?? '-',
            'Status Kepemilikan' => $v->kepemilikan_status,
            'Foto' => $v->foto ? url('storage/'.$v->foto) : '-',
            'Keterangan' => $v->keperluan ?? '-',
        ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Kendaraan', 'Kendaraan'),
            'Data_Kendaraan.xlsx'
        );
    }

    protected function digitalAssetsExport($filter = 'all')
    {
        $query = DigitalAsset::orderBy('nama_aset');
        if ($filter !== 'all') {
            $query->where('is_active', $filter === 'aktif' ? 1 : 0);
        }
        $data = $query->get()->map(fn ($a) => [
            'Nama Aset' => $a->nama_aset,
            'Email' => $a->email,
            'Mulai' => $a->mulai?->format('d/m/Y'),
            'Berakhir' => $a->berakhir?->format('d/m/Y'),
            'Biaya' => $a->biaya ? 'Rp '.number_format($a->biaya, 0, ',', '.') : '-',
            'Status' => $a->is_active ? 'Aktif' : 'Tidak Aktif',
            'PIC' => $a->pic,
            'Jabatan' => $a->jabatan,
            'Keterangan' => $a->keperluan ?? '-',
        ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Aset Digital', 'Aset Digital'),
            'Data_Aset_Digital.xlsx'
        );
    }

    protected function simCardsExport($filter = 'all')
    {
        $query = SimCard::orderBy('nomor_kartu');
        if ($filter !== 'all') {
            $query->where('status_kartu', $filter === 'aktif' ? 1 : 0);
        }
        $data = $query->get()->map(fn ($s) => [
            'Nomor Kartu' => $s->nomor_kartu,
            'Provider' => $s->provider ?? '-',
            'Pemilik' => $s->pemilik ?? '-',
            'Status' => $s->status,
            'Keterangan' => $s->keterangan ?? '-',
        ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data SIM Card', 'SIM Card'),
            'Data_SIM_Card.xlsx'
        );
    }

    protected function peralatanKantorExport($filter = 'all')
    {
        $query = PeralatanKantor::orderBy('nama_barang');
        if ($filter !== 'all') {
            $query->where('kondisi', $filter);
        }
        $data = $query->get()->map(fn ($p) => [
            'Nama Barang' => $p->nama_barang,
            'Merek' => $p->merek ?? '-',
            'Jumlah' => $p->jumlah,
            'Lokasi' => $p->lokasi ?? '-',
            'Kondisi' => $p->kondisi,
            'Keterangan' => $p->keterangan ?? '-',
        ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Peralatan Kantor', 'Peralatan Kantor'),
            'Data_Peralatan_Kantor.xlsx'
        );
    }

    protected function rukoExport($filter = 'all')
    {
        $query = AsetRuko::orderBy('nama_aset');
        if ($filter !== 'all') {
            $query->where('kondisi', $filter);
        }
        $data = $query->get()->map(fn ($r) => [
            'Nama Aset' => $r->nama_aset,
            'Lokasi' => $r->lokasi,
            'Jumlah' => $r->jumlah,
            'Kondisi' => $r->kondisi,
        ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Aset Ruko', 'Ruko'),
            'Data_Ruko.xlsx'
        );
    }

    protected function pembayaranExport($jenis, $filter = 'all')
    {
        if ($jenis === 'internet') {
            $query = WifiPayment::orderBy('created_at', 'desc');
            if ($filter !== 'all') {
                $query->where('status', $filter);
            }
            $data = $query->get()->map(fn ($w) => [
                'Nama Internet' => $w->nama_internet,
                'Provider' => $w->provider,
                'PIC' => $w->pic,
                'Jabatan' => $w->jabatan,
                'Masa Tenggang' => $w->masa_tenggang?->format('d/m/Y'),
                'Biaya' => 'Rp '.number_format($w->biaya, 0, ',', '.'),
                'Status' => $w->status,
                'Tgl Bayar' => $w->tanggal_bayar?->format('d/m/Y') ?? '-',
            ]);

            return Excel::download(
                new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Pembayaran Internet', 'Internet'),
                'Data_Pembayaran_Internet.xlsx'
            );
        }

        if ($jenis === 'aset_digital') {
            $query = PembayaranAsetDigital::orderBy('created_at', 'desc');
        } elseif ($jenis === 'ipl_ruko') {
            $query = PembayaranIplRuko::orderBy('created_at', 'desc');
        } else {
            $query = Payment::where('jenis', 'listrik')->orderBy('created_at', 'desc');
        }
        if ($filter !== 'all') {
            $query->where('status', $filter);
        }
        $data = $query->get()->map(fn ($p) => [
            'Periode' => $p->periode,
            'Tagihan' => $p->tanggal_tagihan?->format('d/m/Y'),
            'Jatuh Tempo' => $p->jatuh_tempo?->format('d/m/Y'),
            'Nominal' => 'Rp '.number_format($p->nominal, 0, ',', '.'),
            'Status' => $p->status,
            'Tgl Bayar' => $p->tanggal_bayar?->format('d/m/Y') ?? '-',
        ]);

        $label = $jenis === 'listrik' ? 'Listrik' : ($jenis === 'aset_digital' ? 'Aset Digital' : ($jenis === 'ipl_ruko' ? 'IPL Ruko' : 'Tagihan'));

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), "Data Pembayaran {$label}", $label),
            "Data_Pembayaran_{$label}.xlsx"
        );
    }

    protected function tokenReadingsExport($request)
    {
        $range = $request->get('range', 'bulanan');
        $query = ElectricityTokenReading::with('checker');
        if ($range === 'harian') {
            $query->whereDate('checked_date', Carbon::today());
        } elseif ($range === 'mingguan') {
            $query->whereBetween('checked_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } else {
            $tokenMonth = $request->get('token_month', now()->format('Y-m'));
            $startDate = Carbon::parse($tokenMonth.'-01')->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
            $query->whereBetween('checked_date', [$startDate, $endDate]);
        }
        $latestPayment = TokenPayment::orderBy('payment_date', 'desc')->first();
        $capacityKwh = $latestPayment ? (float) $latestPayment->amount_kwh : 7000;

        $data = $query->orderBy('checked_date', 'desc')
            ->get()->map(fn ($r) => [
                'Tanggal Check' => $r->checked_date->format('d/m/Y'),
                'Sisa KWH' => $r->remaining_kwh,
                'Terpakai' => $capacityKwh - (float) $r->remaining_kwh,
                'Status' => $r->status ?? '-',
                'Pengecek' => $r->checker?->name ?? '-',
                'Catatan' => $r->notes ?: 'Tidak ada catatan',
            ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Pengecekan Token Listrik', 'Token Listrik'),
            'Data_Token_Listrik.xlsx'
        );
    }

    protected function tokenTopupsExport($request)
    {
        $range = $request->get('range', 'bulanan');
        $query = TokenPayment::with('creator');
        if ($range === 'harian') {
            $query->whereDate('payment_date', Carbon::today());
        } elseif ($range === 'mingguan') {
            $query->whereBetween('payment_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        }
        $data = $query->orderBy('payment_date', 'desc')
            ->get()->map(fn ($t) => [
                'Tanggal Bayar' => $t->payment_date->format('d/m/Y'),
                'Periode' => $t->period,
                'Jumlah KWH' => $t->amount_kwh,
                'Oleh' => $t->creator?->name ?? '-',
                'Catatan' => $t->notes ?: 'Tidak ada catatan',
            ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Riwayat Top Up Token', 'Top Up Token'),
            'Riwayat_TopUp_Token.xlsx'
        );
    }
}
