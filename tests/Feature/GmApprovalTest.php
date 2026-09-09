<?php

namespace Tests\Feature;

use App\Models\PembayaranAsetMes;
use App\Models\PembayaranAsetTim;
use App\Models\PembayaranIplRuko;
use App\Models\User;
use App\Models\WifiPayment;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class GmApprovalTest extends TestCase
{
    use DatabaseTransactions;

    protected $admin;

    protected $gm;

    protected $koordinator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->buildSchema();

        $this->admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => 'password',
            'role' => 'admin',
            'is_active' => true,
        ]);
        $this->gm = User::create([
            'name' => 'GM',
            'username' => 'gm',
            'password' => 'password',
            'role' => 'gm',
            'is_active' => true,
        ]);
        $this->koordinator = User::create([
            'name' => 'Koordinator',
            'username' => 'koord',
            'password' => 'password',
            'role' => 'koordinator',
            'is_active' => true,
        ]);
    }

    public function test_gm_can_approve_single_pending_item_submitted_by_another_user(): void
    {
        WifiPayment::create([
            'nama_internet' => 'Test Internet',
            'provider' => 'Provider',
            'pic' => 'PIC',
            'jabatan' => 'Staff',
            'masa_tenggang' => now()->addMonth(),
            'biaya' => 500000,
            'status' => 'pending',
            'requested_by' => $this->koordinator->id,
        ]);

        $this->actingAs($this->gm);

        $response = $this->postJson('/admin/payment-approvals/1/approve', [
            'jenis' => 'internet',
        ]);

        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('wifi_payments', ['status' => 'lunas']);
    }

    public function test_gm_can_approve_all_pending_items(): void
    {
        WifiPayment::create([
            'nama_internet' => 'Test Internet',
            'provider' => 'Provider',
            'pic' => 'PIC',
            'jabatan' => 'Staff',
            'masa_tenggang' => now()->addMonth(),
            'biaya' => 500000,
            'status' => 'pending',
            'requested_by' => $this->koordinator->id,
        ]);

        PembayaranIplRuko::create([
            'periode' => 'Sep 2026',
            'tanggal_tagihan' => now()->subMonth(),
            'jatuh_tempo' => now()->addMonth(),
            'nominal' => 1500000,
            'pic' => 'PIC',
            'jabatan' => 'Staff',
            'status' => 'pending',
            'requested_by' => $this->koordinator->id,
            'period' => 'bulanan',
        ]);

        $this->actingAs($this->gm);

        $response = $this->postJson('/admin/payment-approvals/approve-all');

        $response->assertJsonStructure(['success', 'message', 'approved', 'skipped']);
        $this->assertDatabaseHas('wifi_payments', ['status' => 'lunas']);
        $this->assertDatabaseHas('pembayaran_ipl_ruko', ['status' => 'lunas']);
    }

    public function test_gm_can_approve_aset_tim(): void
    {
        $asetTimId = \DB::table('aset_tim')->insertGetId([
            'name' => 'Aset Tim Test',
            'penanggung_jawab' => $this->koordinator->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PembayaranAsetTim::create([
            'aset_tim_id' => $asetTimId,
            'periode' => 'Sep 2026',
            'tanggal_tagihan' => now()->subMonth(),
            'jatuh_tempo' => now()->addMonth(),
            'nominal' => 500000,
            'pic' => 'PIC',
            'jabatan' => 'Staff',
            'status' => 'pending',
            'requested_by' => $this->koordinator->id,
        ]);

        $this->actingAs($this->gm);

        $response = $this->postJson('/admin/payment-approvals/1/approve', [
            'jenis' => 'aset_tim',
        ]);

        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('pembayaran_aset_tim', ['status' => 'lunas']);
    }

    public function test_gm_can_approve_aset_mes(): void
    {
        $asetMesId = \DB::table('aset_mes')->insertGetId([
            'name' => 'Aset MES Test',
            'penanggung_jawab' => $this->koordinator->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PembayaranAsetMes::create([
            'aset_mes_id' => $asetMesId,
            'periode' => 'Sep 2026',
            'tanggal_tagihan' => now()->subMonth(),
            'jatuh_tempo' => now()->addMonth(),
            'nominal' => 500000,
            'pic' => 'PIC',
            'jabatan' => 'Staff',
            'status' => 'pending',
            'requested_by' => $this->koordinator->id,
        ]);

        $this->actingAs($this->gm);

        $response = $this->postJson('/admin/payment-approvals/1/approve', [
            'jenis' => 'aset_mes',
        ]);

        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('pembayaran_aset_mes', ['status' => 'lunas']);
    }

    public function test_gm_can_approve_own_submitted_pending_item(): void
    {
        WifiPayment::create([
            'nama_internet' => 'Test Internet',
            'provider' => 'Provider',
            'pic' => 'PIC',
            'jabatan' => 'Staff',
            'masa_tenggang' => now()->addMonth(),
            'biaya' => 500000,
            'status' => 'pending',
            'requested_by' => $this->gm->id,
        ]);

        $this->actingAs($this->gm);

        $response = $this->postJson('/admin/payment-approvals/1/approve', [
            'jenis' => 'internet',
        ]);

        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('wifi_payments', [
            'status' => 'lunas',
            'approved_by' => $this->gm->id,
        ]);
    }

    public function test_gm_approve_all_does_not_skip_own_submitted_item(): void
    {
        WifiPayment::create([
            'nama_internet' => 'Test Internet',
            'provider' => 'Provider',
            'pic' => 'PIC',
            'jabatan' => 'Staff',
            'masa_tenggang' => now()->addMonth(),
            'biaya' => 500000,
            'status' => 'pending',
            'requested_by' => $this->gm->id,
        ]);

        $this->actingAs($this->gm);

        $response = $this->postJson('/admin/payment-approvals/approve-all');

        $response->assertJson(['success' => true, 'approved' => 1, 'skipped' => 0]);
        $this->assertDatabaseHas('wifi_payments', ['status' => 'lunas']);
    }

    public function test_koordinator_cannot_approve_own_submitted_item(): void
    {
        WifiPayment::create([
            'nama_internet' => 'Test Internet',
            'provider' => 'Provider',
            'pic' => 'PIC',
            'jabatan' => 'Staff',
            'masa_tenggang' => now()->addMonth(),
            'biaya' => 500000,
            'status' => 'pending',
            'requested_by' => $this->koordinator->id,
        ]);

        $this->actingAs($this->koordinator);

        $response = $this->postJson('/admin/payment-approvals/1/approve', [
            'jenis' => 'internet',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('wifi_payments', ['status' => 'pending']);
    }

    protected function buildSchema(): void
    {
        Schema::create('users', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('username')->unique();
            $t->string('password');
            $t->string('role')->default('user');
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('wifi_payments', function (Blueprint $t) {
            $t->id();
            $t->string('nama_internet')->nullable();
            $t->string('provider')->nullable();
            $t->string('pic')->nullable();
            $t->string('jabatan')->nullable();
            $t->date('masa_tenggang')->nullable();
            $t->decimal('biaya', 15, 2)->default(0);
            $t->string('status')->default('pending');
            $t->date('tanggal_bayar')->nullable();
            $t->unsignedBigInteger('requested_by')->nullable();
            $t->unsignedBigInteger('approved_by')->nullable();
            $t->timestamp('approved_at')->nullable();
            $t->string('bukti_bayar')->nullable();
            $t->text('notes')->nullable();
            $t->string('period')->nullable();
            $t->timestamps();
        });

        Schema::create('pembayaran_ipl_ruko', function (Blueprint $t) {
            $t->id();
            $t->string('periode');
            $t->date('tanggal_tagihan');
            $t->date('jatuh_tempo');
            $t->decimal('nominal', 15, 2)->default(0);
            $t->string('status')->default('pending');
            $t->date('tanggal_bayar')->nullable();
            $t->string('pic')->nullable();
            $t->string('jabatan')->nullable();
            $t->unsignedBigInteger('requested_by')->nullable();
            $t->unsignedBigInteger('approved_by')->nullable();
            $t->timestamp('approved_at')->nullable();
            $t->string('bukti_bayar')->nullable();
            $t->text('notes')->nullable();
            $t->string('period')->nullable();
            $t->timestamps();
        });

        Schema::create('pembayaran_aset_digital', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('digital_asset_id')->nullable();
            $t->string('periode');
            $t->date('tanggal_tagihan');
            $t->date('jatuh_tempo');
            $t->decimal('nominal', 15, 2)->default(0);
            $t->string('pic')->nullable();
            $t->string('jabatan')->nullable();
            $t->string('status')->default('pending');
            $t->date('tanggal_bayar')->nullable();
            $t->unsignedBigInteger('requested_by')->nullable();
            $t->unsignedBigInteger('approved_by')->nullable();
            $t->timestamp('approved_at')->nullable();
            $t->string('bukti_bayar')->nullable();
            $t->text('notes')->nullable();
            $t->string('period')->nullable();
            $t->timestamps();
        });

        Schema::create('aset_tim', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->unsignedBigInteger('penanggung_jawab')->nullable();
            $t->timestamps();
        });

        Schema::create('pembayaran_aset_tim', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('aset_tim_id');
            $t->string('periode');
            $t->date('tanggal_tagihan');
            $t->date('jatuh_tempo');
            $t->decimal('nominal', 15, 2)->default(0);
            $t->string('pic')->nullable();
            $t->string('jabatan')->nullable();
            $t->string('status')->default('pending');
            $t->date('tanggal_bayar')->nullable();
            $t->unsignedBigInteger('requested_by')->nullable();
            $t->unsignedBigInteger('approved_by')->nullable();
            $t->timestamp('approved_at')->nullable();
            $t->string('bukti_bayar')->nullable();
            $t->text('notes')->nullable();
            $t->string('period')->nullable();
            $t->timestamps();
        });

        Schema::create('aset_mes', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->unsignedBigInteger('penanggung_jawab')->nullable();
            $t->timestamps();
        });

        Schema::create('pembayaran_aset_mes', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('aset_mes_id');
            $t->string('periode');
            $t->date('tanggal_tagihan');
            $t->date('jatuh_tempo');
            $t->decimal('nominal', 15, 2)->default(0);
            $t->string('pic')->nullable();
            $t->string('jabatan')->nullable();
            $t->string('status')->default('pending');
            $t->date('tanggal_bayar')->nullable();
            $t->unsignedBigInteger('requested_by')->nullable();
            $t->unsignedBigInteger('approved_by')->nullable();
            $t->timestamp('approved_at')->nullable();
            $t->string('bukti_bayar')->nullable();
            $t->text('notes')->nullable();
            $t->string('period')->nullable();
            $t->timestamps();
        });

        Schema::create('notifications', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('user_id');
            $t->string('type');
            $t->string('title');
            $t->string('message');
            $t->string('url')->nullable();
            $t->string('dedup_key')->nullable();
            $t->boolean('is_read')->default(false);
            $t->timestamp('read_at')->nullable();
            $t->timestamps();
        });

        Schema::create('vehicles', function (Blueprint $t) {
            $t->id();
            $t->string('nama_kendaraan');
            $t->string('jenis_kendaraan');
            $t->string('plat_nomor')->unique();
            $t->year('tahun');
            $t->date('pajak_tahunan');
            $t->date('pajak_5_tahun');
            $t->string('kepemilikan_status')->default('Milik Perusahaan');
            $t->decimal('biaya_kendaraan', 15, 2)->default(0);
            $t->string('pic');
            $t->string('jabatan');
            $t->text('keperluan')->nullable();
            $t->timestamps();
        });

        Schema::create('vehicle_pajak_requests', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('vehicle_id');
            $t->unsignedBigInteger('requested_by');
            $t->string('jenis');
            $t->decimal('nominal', 15, 2)->default(0);
            $t->string('bukti_bayar');
            $t->string('status')->default('pending');
            $t->unsignedBigInteger('approved_by')->nullable();
            $t->timestamp('approved_at')->nullable();
            $t->text('notes')->nullable();
            $t->timestamps();
        });
    }
}
