<?php

namespace Tests\Feature;

use App\Imports\UsersNikImport;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class UserNikTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->buildSchema();
        $this->team = Team::create(['name' => 'Tim Test']);
        $this->admin = User::create(['name' => 'Admin', 'username' => 'admin', 'password' => Hash::make('x'), 'role' => 'admin']);
    }

    public function test_admin_account_store_saves_nik(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.admins.store'), [
            'name' => 'GM Baru',
            'username' => 'gm_baru',
            'nik' => 'NIK-500',
            'password' => 'secret123',
            'role' => 'gm',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['username' => 'gm_baru', 'nik' => 'NIK-500']);
    }

    public function test_admin_account_update_saves_nik(): void
    {
        $gm = User::create(['name' => 'GM', 'username' => 'gm_existing', 'password' => Hash::make('x'), 'role' => 'gm']);
        $response = $this->actingAs($this->admin)->put(route('admin.admins.update', $gm), [
            'name' => 'GM Lama',
            'username' => 'gm_existing',
            'nik' => 'NIK-501',
            'role' => 'gm',
            'is_active' => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['username' => 'gm_existing', 'nik' => 'NIK-501']);
    }

    public function test_karyawan_store_saves_nik(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.admins.karyawan.store'), [
            'name' => 'Karyawan Baru',
            'username' => 'karyawan_baru',
            'nik' => 'NIK-502',
            'password' => 'secret123',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['username' => 'karyawan_baru', 'nik' => 'NIK-502']);
    }

    public function test_users_store_saves_nik(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.users.store'), [
            'name' => 'Koordinator Baru',
            'username' => 'koord_baru',
            'nik' => 'NIK-503',
            'password' => 'secret123',
            'role' => 'koordinator',
            'team_id' => $this->team->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['username' => 'koord_baru', 'nik' => 'NIK-503']);
    }

    public function test_nik_validation_rejects_duplicate(): void
    {
        User::create(['name' => 'A', 'username' => 'a', 'password' => Hash::make('x'), 'role' => 'admin', 'nik' => 'NIK-900']);

        $response = $this->actingAs($this->admin)->post(route('admin.admins.store'), [
            'name' => 'B',
            'username' => 'b',
            'nik' => 'NIK-900',
            'password' => 'secret123',
            'role' => 'gm',
        ]);

        $response->assertSessionHasErrors('nik');
    }

    public function test_nik_template_downloads(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.nik.template'));

        $response->assertOk();
    }

    public function test_import_nik_updates_users_by_username(): void
    {
        User::create(['name' => 'GM', 'username' => 'gm', 'password' => Hash::make('x'), 'role' => 'gm']);

        $csv = "Username,Nama,NIK\nadmin,Admin Master,NIK-100\ngm,General Manager,NIK-200\nunknown,Orang Asing,NIK-300\n";
        $path = tempnam(sys_get_temp_dir(), 'nik');
        file_put_contents($path, $csv);
        $file = new UploadedFile($path, 'nik.csv', 'text/csv', null, true);

        $response = $this->actingAs($this->admin)->post(route('admin.users.nik.import'), ['file' => $file]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['username' => 'admin', 'nik' => 'NIK-100']);
        $this->assertDatabaseHas('users', ['username' => 'gm', 'nik' => 'NIK-200']);
        $response->assertSessionHas('import_errors');
    }

    public function test_import_nik_rejects_duplicate_nik(): void
    {
        User::create(['name' => 'GM', 'username' => 'gm', 'password' => Hash::make('x'), 'role' => 'gm']);

        $csv = "Username,Nama,NIK\nadmin,Admin Master,NIK-100\ngm,General Manager,NIK-100\n";
        $path = tempnam(sys_get_temp_dir(), 'nik');
        file_put_contents($path, $csv);
        $file = new UploadedFile($path, 'nik.csv', 'text/csv', null, true);

        $import = new UsersNikImport;
        Excel::import($import, $file);

        $this->assertSame(1, $import->getSuccessCount());
        $this->assertNotEmpty($import->getErrors());
        $this->assertDatabaseHas('users', ['username' => 'gm', 'nik' => null]);
    }

    protected function buildSchema(): void
    {
        Schema::create('teams', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('description')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
        Schema::create('users', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('username')->unique();
            $t->string('nik', 50)->nullable()->unique();
            $t->string('email')->nullable();
            $t->string('password');
            $t->string('role', 30)->default('user');
            $t->foreignId('team_id')->nullable();
            $t->boolean('is_active')->default(true);
            $t->string('avatar')->nullable();
            $t->string('theme', 20)->nullable();
            $t->boolean('email_notifications')->default(true);
            $t->boolean('app_notifications')->default(true);
            $t->rememberToken();
            $t->timestamps();
        });
    }
}
