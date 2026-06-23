<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DataExport;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AsetRuko;
use App\Models\DigitalAsset;
use App\Models\ElectricityTokenReading;
use App\Models\Meeting;
use App\Models\Payment;
use App\Models\PeralatanKantor;
use App\Models\Room;
use App\Models\SimCard;
use App\Models\Team;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\WifiPayment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $type = $request->query('type');
        $jenis = $request->query('jenis');

        $exports = [
            'assets' => fn () => $this->assetsExport(),
            'users' => fn () => $this->usersExport(),
            'admins' => fn () => $this->adminsExport(),
            'teams' => fn () => $this->teamsExport(),
            'rooms' => fn () => $this->roomsExport(),
            'meetings' => fn () => $this->meetingsExport(),
            'vehicles' => fn () => $this->vehiclesExport(),
            'digital-assets' => fn () => $this->digitalAssetsExport(),
            'sim-cards' => fn () => $this->simCardsExport(),
            'peralatan-kantor' => fn () => $this->peralatanKantorExport(),
            'ruko' => fn () => $this->rukoExport(),
            'pembayaran' => fn () => $this->pembayaranExport($jenis),
            'token-readings' => fn () => $this->tokenReadingsExport(),
        ];

        if (! isset($exports[$type])) {
            return redirect()->back()->with('error', 'Tipe export tidak valid.');
        }

        return $exports[$type]();
    }

    protected function assetsExport()
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

    protected function usersExport()
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

    protected function adminsExport()
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

    protected function teamsExport()
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

    protected function roomsExport()
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

    protected function meetingsExport()
    {
        $data = Meeting::with(['requester', 'room', 'team'])
            ->orderBy('meeting_date', 'desc')->get()->map(fn ($m) => [
                'Judul' => $m->title,
                'Tanggal' => $m->meeting_date->format('d/m/Y'),
                'Jam' => $m->start_time->format('H:i') . ' - ' . $m->end_time->format('H:i'),
                'Ruangan' => $m->room?->name ?? '-',
                'Pemohon' => $m->requester?->name ?? '-',
                'Tim' => $m->team?->name ?? '-',
                'Status' => $m->status,
            ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Meeting', 'Meeting'),
            'Data_Meeting.xlsx'
        );
    }

    protected function vehiclesExport()
    {
        $data = Vehicle::orderBy('nama_kendaraan')->get()->map(fn ($v) => [
            'Nama Kendaraan' => $v->nama_kendaraan,
            'Nomor Polisi' => $v->plat_nomor ?? '-',
            'Jenis Kendaraan' => $v->jenis_kendaraan,
            'Merk / Tipe' => $v->merk_tipe ?? '-',
            'Tahun' => $v->tahun,
            'Warna' => $v->warna ?? '-',
            'Nomor Rangka' => $v->nomor_rangka ?? '-',
            'Nomor Mesin' => $v->nomor_mesin ?? '-',
            'Status Kepemilikan' => $v->kepemilikan_status,
            'Foto' => $v->foto ? url('storage/' . $v->foto) : '-',
            'Keterangan' => $v->keperluan ?? '-',
        ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Kendaraan', 'Kendaraan'),
            'Data_Kendaraan.xlsx'
        );
    }

    protected function digitalAssetsExport()
    {
        $data = DigitalAsset::orderBy('nama_aset')->get()->map(fn ($a) => [
            'Nama Aset' => $a->nama_aset,
            'Email' => $a->email,
            'Mulai' => $a->mulai?->format('d/m/Y'),
            'Berakhir' => $a->berakhir?->format('d/m/Y'),
            'Biaya' => $a->biaya ? 'Rp ' . number_format($a->biaya, 0, ',', '.') : '-',
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

    protected function simCardsExport()
    {
        $data = SimCard::orderBy('nomor_kartu')->get()->map(fn ($s) => [
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

    protected function peralatanKantorExport()
    {
        $data = PeralatanKantor::orderBy('nama_barang')->get()->map(fn ($p) => [
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

    protected function rukoExport()
    {
        $data = AsetRuko::orderBy('nama_ruko')->get()->map(fn ($r) => [
            'Nama Ruko' => $r->nama_ruko,
            'Alamat' => $r->alamat ?? '-',
            'Status' => $r->status,
            'Keterangan' => $r->keterangan ?? '-',
        ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Aset Ruko', 'Ruko'),
            'Data_Ruko.xlsx'
        );
    }

    protected function pembayaranExport($jenis)
    {
        if ($jenis === 'internet') {
            $data = WifiPayment::orderBy('created_at', 'desc')->get()->map(fn ($w) => [
                'Nama Internet' => $w->nama_internet,
                'Provider' => $w->provider,
                'PIC' => $w->pic,
                'Jabatan' => $w->jabatan,
                'Masa Tenggang' => $w->masa_tenggang?->format('d/m/Y'),
                'Biaya' => 'Rp ' . number_format($w->biaya, 0, ',', '.'),
                'Status' => $w->status,
                'Tgl Bayar' => $w->tanggal_bayar?->format('d/m/Y') ?? '-',
            ]);

            return Excel::download(
                new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Pembayaran Internet', 'Internet'),
                'Data_Pembayaran_Internet.xlsx'
            );
        }

        $data = Payment::orderBy('created_at', 'desc')->get()->map(fn ($p) => [
            'Periode' => $p->periode,
            'Tagihan' => $p->tanggal_tagihan?->format('d/m/Y'),
            'Jatuh Tempo' => $p->jatuh_tempo?->format('d/m/Y'),
            'Nominal' => 'Rp ' . number_format($p->nominal, 0, ',', '.'),
            'Status' => $p->status,
            'Tgl Bayar' => $p->tanggal_bayar?->format('d/m/Y') ?? '-',
        ]);

        $label = $jenis === 'listrik' ? 'Listrik' : ($jenis === 'ipl_ruko' ? 'IPL Ruko' : 'Tagihan');

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), "Data Pembayaran {$label}", $label),
            "Data_Pembayaran_{$label}.xlsx"
        );
    }

    protected function tokenReadingsExport()
    {
        $data = ElectricityTokenReading::with('checker')
            ->orderBy('checked_date', 'desc')
            ->get()->map(fn ($r) => [
                'Tanggal Check' => $r->checked_date->format('d/m/Y'),
                'Sisa KWH' => $r->remaining_kwh,
                'Status' => $r->status ?? '-',
                'Pengecek' => $r->checker?->name ?? '-',
                'Catatan' => $r->notes ?? '-',
            ]);

        return Excel::download(
            new DataExport(collect($data), array_keys($data->first() ?? []), 'Data Pengecekan Token Listrik', 'Token Listrik'),
            'Data_Token_Listrik.xlsx'
        );
    }
}
