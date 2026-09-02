<?php

namespace Tests\Feature;

use App\Console\Commands\SyncDigitalAssetPayments;
use App\Http\Controllers\Admin\DigitalAssetController;
use App\Http\Controllers\Api\DigitalAssetApiController;
use App\Models\DigitalAsset;
use App\Models\PembayaranAsetDigital;
use App\Models\User;
use App\Services\TagihanService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DigitalAssetTagihanTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->buildSchema();
        $this->actingAs(User::create([
            'name' => 'Admin Test',
            'username' => 'admin_test',
            'password' => 'password',
            'role' => 'admin',
            'is_active' => true,
        ]));
    }

    public function test_web_store_asset_far_from_expiry_does_not_create_tagihan(): void
    {
        $request = Request::create(route('admin.digital-assets.store'), 'POST', [
            'nama_aset' => 'Figma',
            'email' => 'figma@example.com',
            'mulai' => now()->toDateString(),
            'berakhir' => now()->addMonths(3)->toDateString(),
            'biaya' => 500000,
            'pic' => 'Admin',
            'jabatan' => 'Admin Master',
            'keperluan' => null,
        ]);

        (new DigitalAssetController)->store($request);

        $this->assertSame(1, DigitalAsset::count());
        $this->assertSame(0, PembayaranAsetDigital::count());
    }

    public function test_web_store_asset_expiring_soon_gets_due_tagihan_not_pending(): void
    {
        $request = Request::create(route('admin.digital-assets.store'), 'POST', [
            'nama_aset' => 'Microsoft 365',
            'email' => 'm365@example.com',
            'mulai' => now()->toDateString(),
            'berakhir' => now()->addDays(5)->toDateString(),
            'biaya' => 100000,
            'pic' => 'Admin',
            'jabatan' => 'Admin Master',
            'keperluan' => null,
        ]);

        (new DigitalAssetController)->store($request);

        $asset = DigitalAsset::first();
        $payment = PembayaranAsetDigital::where('digital_asset_id', $asset->id)->first();

        $this->assertNotNull($payment);
        $this->assertSame('jatuh_tempo', $payment->status);
        $this->assertSame(now()->addDays(5)->toDateString(), $payment->jatuh_tempo->toDateString());
    }

    public function test_api_store_asset_expiring_soon_gets_due_tagihan_not_pending(): void
    {
        $request = Request::create('/api/digital-assets', 'POST', [
            'nama_aset' => 'Canva Pro',
            'email' => 'canva@example.com',
            'mulai' => now()->toDateString(),
            'berakhir' => now()->addDays(3)->toDateString(),
            'biaya' => 80000,
            'pic' => 'Admin',
            'jabatan' => 'Admin Master',
            'keperluan' => null,
        ]);

        (new DigitalAssetApiController)->store($request);

        $asset = DigitalAsset::first();
        $payment = PembayaranAsetDigital::where('digital_asset_id', $asset->id)->first();

        $this->assertNotNull($payment);
        $this->assertSame('jatuh_tempo', $payment->status);
        $this->assertSame(now()->addDays(3)->toDateString(), $payment->jatuh_tempo->toDateString());
    }

    public function test_sync_command_only_creates_tagihan_for_near_expiry_assets(): void
    {
        DigitalAsset::create([
            'nama_aset' => 'Zoom',
            'email' => 'zoom@example.com',
            'mulai' => now()->toDateString(),
            'berakhir' => now()->addDays(5)->toDateString(),
            'biaya' => 200000,
            'pic' => 'Admin',
            'jabatan' => 'Admin Master',
            'keperluan' => null,
            'is_active' => true,
        ]);
        DigitalAsset::create([
            'nama_aset' => 'Slack',
            'email' => 'slack@example.com',
            'mulai' => now()->toDateString(),
            'berakhir' => now()->addMonths(2)->toDateString(),
            'biaya' => 150000,
            'pic' => 'Admin',
            'jabatan' => 'Admin Master',
            'keperluan' => null,
            'is_active' => true,
        ]);

        Artisan::call(SyncDigitalAssetPayments::class);

        $this->assertSame(1, PembayaranAsetDigital::count());
        $payment = PembayaranAsetDigital::first();
        $this->assertSame('Zoom', $payment->periode);
        $this->assertSame('jatuh_tempo', $payment->status);
    }

    public function test_item_kueri_aset_digital_hanya_menampilkan_tagihan_dalam_h7(): void
    {
        $due = PembayaranAsetDigital::create([
            'periode' => 'Tenggat 3 Hari',
            'tanggal_tagihan' => now()->toDateString(),
            'jatuh_tempo' => now()->addDays(3)->toDateString(),
            'nominal' => 100000,
            'status' => 'jatuh_tempo',
        ]);
        PembayaranAsetDigital::create([
            'periode' => 'Menunggu Bulan Depan',
            'tanggal_tagihan' => now()->toDateString(),
            'jatuh_tempo' => now()->addDays(60)->toDateString(),
            'nominal' => 200000,
            'status' => 'pending',
        ]);

        $rows = TagihanService::itemsQuery('aset_digital')->get();

        $this->assertCount(1, $rows);
        $this->assertSame($due->id, $rows->first()->id);
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

        Schema::create('digital_assets', function (Blueprint $t) {
            $t->id();
            $t->string('nama_aset');
            $t->string('email');
            $t->date('mulai');
            $t->date('berakhir');
            $t->decimal('biaya', 15, 2)->default(0);
            $t->string('pic');
            $t->string('jabatan');
            $t->text('keperluan')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('pembayaran_aset_digital', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('digital_asset_id')->nullable();
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
    }
}
