<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\VehicleController;
use App\Models\PeralatanKantor;
use App\Models\Vehicle;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminVehiclesKendaraanTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->buildSchema();
    }

    public function test_vehicle_index_merges_peralatan_kendaraan(): void
    {
        Vehicle::create([
            'nama_kendaraan' => 'Mobil Avanza',
            'jenis_kendaraan' => 'Mobil',
            'merk_tipe' => 'Toyota',
            'plat_nomor' => 'B 1234 CD',
            'tahun' => 2020,
            'warna' => 'Hitam',
            'nomor_rangka' => 'RNG-001',
            'nomor_mesin' => 'MSN-001',
            'pajak_tahunan' => '2026-01-01',
            'pajak_5_tahun' => '2028-01-01',
            'kepemilikan_status' => 'Milik Perusahaan',
            'biaya_kendaraan' => 0,
            'pic' => 'Admin',
            'jabatan' => 'Admin',
            'keperluan' => 'Operasional',
        ]);

        $pk = PeralatanKantor::create([
            'kode_aset' => '439',
            'barcode' => '439',
            'nama_barang' => 'Motor Scoopy',
            'sub_kategori' => 'Kendaraan',
            'lokasi_unit' => 'Kantor Pusat',
            'ruangan' => 'Gudang',
            'milik' => 'Milik Perusahaan',
            'pengadaan_tahun' => 2021,
            'tanggal_pembelian' => '2021-05-01',
            'pic' => 'Admin',
            'jabatan' => 'Admin',
            'kondisi' => 'baik',
        ]);

        $data = (new VehicleController)->index(Request::create(route('admin.vehicles.index'), 'GET', ['status' => 'all']))->getData();

        $this->assertSame(1, $data['peralatanCount']);
        $this->assertSame(2, $data['stats']['total']);

        $peralatan = $data['vehicles']->firstWhere('sumber', 'peralatan');
        $this->assertNotNull($peralatan);
        $this->assertSame('pk-'.$pk->id, $peralatan->id);
        $this->assertSame('Motor Scoopy', $peralatan->nama_kendaraan);
        $this->assertSame(2021, $peralatan->tahun);

        $this->assertTrue($data['vehicles']->contains(fn ($v) => $v->nama_kendaraan === 'Mobil Avanza'));

        $json = collect($data['vehiclesJson']);
        $this->assertSame('pk-'.$pk->id, $json->firstWhere('sumber', 'peralatan')['id']);
    }

    public function test_vehicle_index_hides_peralatan_when_pajak_filter_active(): void
    {
        PeralatanKantor::create([
            'kode_aset' => '439',
            'barcode' => '439',
            'nama_barang' => 'Motor Scoopy',
            'sub_kategori' => 'Kendaraan',
            'lokasi_unit' => 'Kantor Pusat',
            'ruangan' => 'Gudang',
            'pengadaan_tahun' => 2021,
            'tanggal_pembelian' => '2021-05-01',
        ]);

        $data = (new VehicleController)->index(Request::create(route('admin.vehicles.index'), 'GET', ['status' => 'mati']))->getData();

        $this->assertSame(0, $data['vehicles']->count());
        $this->assertTrue($data['vehiclesJson']->isEmpty());
    }

    protected function buildSchema(): void
    {
        Schema::create('vehicles', function (Blueprint $t) {
            $t->id();
            $t->string('nama_kendaraan');
            $t->string('jenis_kendaraan');
            $t->string('merk_tipe')->nullable();
            $t->string('plat_nomor')->unique();
            $t->integer('tahun');
            $t->string('warna')->nullable();
            $t->string('nomor_rangka')->nullable();
            $t->string('nomor_mesin')->nullable();
            $t->string('foto')->nullable();
            $t->date('pajak_tahunan');
            $t->date('pajak_5_tahun');
            $t->string('kepemilikan_status')->default('Milik Perusahaan');
            $t->decimal('biaya_kendaraan', 15, 2)->default(0);
            $t->decimal('biaya_pajak_tahunan', 15, 2)->nullable();
            $t->decimal('biaya_pajak_5_tahun', 15, 2)->nullable();
            $t->string('pic');
            $t->string('jabatan');
            $t->text('keperluan')->nullable();
            $t->timestamps();
        });

        Schema::create('peralatan_kantor', function (Blueprint $t) {
            $t->id();
            $t->string('kode_aset')->unique();
            $t->string('barcode')->unique();
            $t->string('foto')->nullable();
            $t->string('nama_barang');
            $t->unsignedInteger('jumlah')->default(1);
            $t->text('detail')->nullable();
            $t->string('sub_kategori')->default('Peralatan Kantor');
            $t->text('keterangan')->nullable();
            $t->string('lokasi_unit');
            $t->string('ruangan');
            $t->string('milik')->default('Milik Perusahaan');
            $t->integer('pengadaan_tahun');
            $t->date('tanggal_pembelian');
            $t->string('kategori_nilai')->default('Rendah');
            $t->string('kategori_ukuran')->default('Kecil');
            $t->decimal('nilai', 15, 2)->default(0);
            $t->integer('waktu_pakai_per_hari')->default(2);
            $t->integer('estimasi_waktu_barang')->default(2);
            $t->decimal('pengurangan_harga_per_hari', 15, 2)->default(0);
            $t->decimal('harga_per_hari_ini', 15, 2)->default(0);
            $t->string('pic')->nullable();
            $t->string('jabatan')->nullable();
            $t->string('atasan')->nullable();
            $t->string('jabatan_atasan')->nullable();
            $t->string('kondisi')->default('baik');
            $t->timestamps();
        });
    }
}
