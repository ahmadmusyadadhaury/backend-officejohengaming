<?php

namespace Tests\Feature;

use App\Http\Controllers\PaymentApprovalController;
use App\Models\PembayaranIplRuko;
use App\Models\User;
use App\Services\TagihanService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class IplRukoApproveTest extends TestCase
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

    public function test_approve_ipl_tidak_auto_create_tagihan_tahun_berikutnya(): void
    {
        $lunasDate = Carbon::create(2026, 9, 22);
        $original = PembayaranIplRuko::create([
            'periode' => 'September 2026',
            'tanggal_tagihan' => Carbon::create(2026, 8, 25),
            'jatuh_tempo' => $lunasDate,
            'nominal' => 1500000,
            'pic' => 'Petugas',
            'jabatan' => 'Admin Ruko',
            'status' => 'pending',
            'period' => 'bulanan',
        ]);

        $request = Request::create('/', 'POST', ['jenis' => 'ipl_ruko']);
        (new PaymentApprovalController)->approve($original->id, $request);

        $this->assertSame('lunas', $original->fresh()->status);
        $this->assertSame(1, PembayaranIplRuko::count());
    }

    public function test_tagihan_tahun_berikutnya_tidak_muncul_di_tagihan_atau_persetujuan(): void
    {
        $original = PembayaranIplRuko::create([
            'periode' => 'September 2026',
            'tanggal_tagihan' => Carbon::create(2026, 8, 25),
            'jatuh_tempo' => Carbon::create(2026, 9, 22),
            'nominal' => 1500000,
            'pic' => 'Petugas',
            'jabatan' => 'Admin Ruko',
            'status' => 'pending',
            'period' => 'bulanan',
        ]);

        $request = Request::create('/', 'POST', ['jenis' => 'ipl_ruko']);
        (new PaymentApprovalController)->approve($original->id, $request);

        $this->assertTrue(PembayaranIplRuko::where('status', 'pending')->doesntExist());
        $this->assertSame(0, TagihanService::itemsQuery('ipl_ruko')->count());
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
    }
}
