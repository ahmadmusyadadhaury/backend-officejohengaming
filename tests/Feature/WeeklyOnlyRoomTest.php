<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Leader\MeetingController;
use App\Models\Meeting;
use App\Models\Room;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class WeeklyOnlyRoomTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->buildSchema();
        $this->team = Team::create(['name' => 'Divisi IT']);
        $this->user = User::create([
            'name' => 'Koordinator',
            'username' => 'weekly_room_user',
            'password' => bcrypt('x'),
            'role' => 'koordinator',
            'team_id' => $this->team->id,
        ]);
    }

    public function test_admin_can_create_weekly_only_room(): void
    {
        $request = Request::create('/admin/rooms', 'POST', [
            'name' => 'Ruang Weekly',
            'capacity' => 20,
            'location' => 'Lantai 1',
            'description' => 'Khusus weekly',
            'is_active' => '1',
            'is_weekly_only' => '1',
        ]);

        (new AdminRoomController)->store($request);

        $room = Room::where('name', 'Ruang Weekly')->first();
        $this->assertNotNull($room);
        $this->assertTrue($room->is_weekly_only);
    }

    public function test_admin_can_update_weekly_only_flag(): void
    {
        $room = Room::create([
            'name' => 'Ruang Biasa',
            'capacity' => 20,
            'location' => 'Lantai 1',
            'is_active' => true,
            'is_weekly_only' => false,
        ]);

        $request = Request::create('/admin/rooms/'.$room->id, 'PUT', [
            'name' => 'Ruang Biasa',
            'capacity' => 20,
            'location' => 'Lantai 1',
            'is_active' => '1',
            'is_weekly_only' => '1',
        ]);

        (new AdminRoomController)->update($request, $room);

        $this->assertTrue($room->fresh()->is_weekly_only);
    }

    public function test_weekly_only_room_is_rejected_for_regular_meeting(): void
    {
        $room = Room::create([
            'name' => 'Ruang Weekly',
            'capacity' => 20,
            'location' => 'Lantai 1',
            'is_active' => true,
            'is_weekly_only' => true,
        ]);

        $this->actingAs($this->user);

        $request = Request::create('/koordinator/meetings', 'POST', [
            'title' => 'Meeting Biasa',
            'room_id' => $room->id,
            'meeting_date' => now()->toDateString(),
            'start_time' => '10:00',
            'end_time' => '11:00',
            'why' => 'Alasan',
            'what' => 'Pembahasan',
            'how_expected' => 'Hasil',
        ], [], [], ['HTTP_REFERER' => 'http://localhost/koordinator/meetings']);

        $response = (new MeetingController)->store($request);

        $this->assertTrue($response->isRedirect());
        $errors = session('errors');
        $this->assertNotNull($errors);
        $this->assertTrue($errors->has('room_id'));
        $this->assertStringContainsString('khusus Weekly Meeting', $errors->first('room_id'));
    }

    public function test_normal_room_is_not_rejected_for_regular_meeting(): void
    {
        $room = Room::create([
            'name' => 'Ruang Biasa',
            'capacity' => 20,
            'location' => 'Lantai 1',
            'is_active' => true,
            'is_weekly_only' => false,
        ]);

        $this->actingAs($this->user);

        $request = Request::create('/koordinator/meetings', 'POST', [
            'title' => 'Meeting Biasa',
            'room_id' => $room->id,
            'meeting_date' => now()->toDateString(),
            'start_time' => '10:00',
            'end_time' => '11:00',
            'why' => 'Alasan',
            'what' => 'Pembahasan',
            'how_expected' => 'Hasil',
        ], [], [], ['HTTP_REFERER' => 'http://localhost/koordinator/meetings']);

        $response = (new MeetingController)->store($request);

        $errors = session('errors');
        $this->assertTrue(is_null($errors) || ! $errors->has('room_id'));
        $this->assertTrue($response->isRedirect());
        $this->assertSame(1, Meeting::count());
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
            $t->string('password');
            $t->string('role', 30)->default('user');
            $t->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();
            $t->boolean('is_active')->default(true);
            $t->rememberToken();
            $t->timestamps();
        });
        Schema::create('rooms', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->unsignedInteger('capacity')->default(50);
            $t->json('facilities')->nullable();
            $t->string('location')->nullable();
            $t->text('description')->nullable();
            $t->boolean('is_active')->default(true);
            $t->boolean('is_weekly_only')->default(false);
            $t->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();
            $t->timestamps();
        });
        Schema::create('meetings', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $t->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $t->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();
            $t->text('why')->nullable();
            $t->text('what')->nullable();
            $t->date('meeting_date');
            $t->string('start_time', 10)->nullable();
            $t->string('end_time', 10)->nullable();
            $t->string('actual_end_time', 10)->nullable();
            $t->text('how_expected')->nullable();
            $t->string('file_path')->nullable();
            $t->string('status', 30)->default('pending');
            $t->string('reject_reason')->nullable();
            $t->unsignedInteger('queue_position')->nullable();
            $t->boolean('is_weekly')->default(false);
            $t->timestamps();
        });
        Schema::create('notifications', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->string('type', 50)->nullable();
            $t->string('title');
            $t->string('message')->nullable();
            $t->string('url')->nullable();
            $t->string('dedup_key')->nullable();
            $t->boolean('is_read')->default(false);
            $t->timestamp('read_at')->nullable();
            $t->timestamps();
        });
    }
}
