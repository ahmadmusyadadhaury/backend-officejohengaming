<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketSla;
use App\Models\TicketTeamMember;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TicketSmokeTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->buildSchema();
        $team = Team::create(['name' => 'Divisi IT']);
        $this->user = User::create(['name' => 'Karyawan', 'username' => 'smoke_user', 'password' => bcrypt('x'), 'role' => 'user', 'team_id' => $team->id]);
        $this->tech = User::create(['name' => 'Teknisi', 'username' => 'smoke_tech', 'password' => bcrypt('x'), 'role' => 'koordinator', 'team_id' => $team->id]);
        $this->leader = User::create(['name' => 'Leader', 'username' => 'smoke_leader', 'password' => bcrypt('x'), 'role' => 'koordinator', 'team_id' => $team->id]);
        TicketTeamMember::create(['user_id' => $this->tech->id, 'is_leader' => false]);
        TicketTeamMember::create(['user_id' => $this->leader->id, 'is_leader' => true]);
        foreach (['low' => 4320, 'medium' => 1440, 'high' => 240, 'urgent' => 120] as $p => $m) {
            TicketSla::create(['priority' => $p, 'duration_minutes' => $m]);
        }
        TicketCategory::create(['name' => 'Hardware']);
        $this->ticket = Ticket::factory()->create(['user_id' => $this->user->id, 'assigned_to' => $this->tech->id]);
    }

    public function test_pages_render_for_user(): void
    {
        foreach (['ticket.dashboard', 'ticket.my', 'ticket.create', 'ticket.notifications.index', 'ticket.notifications.unread-count'] as $route) {
            $this->actingAs($this->user)->get(route($route))->assertSuccessful($route);
        }
        $this->actingAs($this->user)->get(route('ticket.show', $this->ticket))->assertSuccessful('ticket.show');
    }

    public function test_pages_render_for_team(): void
    {
        foreach (['ticket.dashboard', 'ticket.index', 'ticket.reports', 'ticket.reports.print'] as $route) {
            $this->actingAs($this->tech)->get(route($route))->assertSuccessful($route);
        }
        $this->actingAs($this->tech)->get(route('ticket.show', $this->ticket))->assertSuccessful('ticket.show tech');
    }

    public function test_pages_render_for_leader(): void
    {
        foreach (['ticket.index', 'ticket.reports', 'ticket.categories.index', 'ticket.sla.index', 'ticket.team.index'] as $route) {
            $this->actingAs($this->leader)->get(route($route))->assertSuccessful($route);
        }
        $this->actingAs($this->leader)->get(route('ticket.show', $this->ticket))->assertSuccessful('ticket.show leader');
    }

    public function test_pages_render_for_admin(): void
    {
        $admin = User::create(['name' => 'Admin', 'username' => 'smoke_admin', 'password' => bcrypt('x'), 'role' => 'admin']);
        foreach (['ticket.index', 'ticket.reports', 'ticket.categories.index', 'ticket.sla.index', 'ticket.team.index'] as $route) {
            $this->actingAs($admin)->get(route($route))->assertSuccessful($route);
        }
        $this->actingAs($admin)->get(route('ticket.reports.export'))->assertSuccessful('ticket.reports.export');
    }

    protected function buildSchema(): void
    {
        Schema::create('teams', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('description')->nullable();
            $t->timestamps();
        });
        Schema::create('users', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('username')->unique();
            $t->string('email')->nullable();
            $t->string('password');
            $t->string('role', 30)->default('user');
            $t->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();
            $t->boolean('is_active')->default(true);
            $t->string('avatar')->nullable();
            $t->string('theme', 20)->nullable();
            $t->boolean('email_notifications')->default(true);
            $t->boolean('app_notifications')->default(true);
            $t->rememberToken();
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
        Schema::create('ticket_categories', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();
            $t->string('description')->nullable();
            $t->timestamps();
        });
        Schema::create('ticket_sla', function (Blueprint $t) {
            $t->id();
            $t->string('priority', 20)->unique();
            $t->unsignedInteger('duration_minutes');
            $t->string('label')->nullable();
            $t->timestamps();
        });
        Schema::create('ticket_team_members', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->boolean('is_leader')->default(false);
            $t->timestamps();
            $t->unique('user_id');
        });
        Schema::create('tickets', function (Blueprint $t) {
            $t->id();
            $t->string('ticket_number', 30)->unique();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('category_id')->nullable()->constrained('ticket_categories')->nullOnDelete();
            $t->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $t->string('title', 100);
            $t->text('description');
            $t->string('location', 100);
            $t->string('department', 100)->nullable();
            $t->string('position', 100)->nullable();
            $t->string('priority', 20)->default('medium');
            $t->string('status', 30)->default('open')->index();
            $t->timestamp('sla_due_at')->nullable();
            $t->timestamp('resolved_at')->nullable();
            $t->timestamp('closed_at')->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->index(['user_id', 'status']);
            $t->index(['assigned_to', 'status']);
        });
        Schema::create('ticket_comments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->text('comment');
            $t->timestamps();
        });
        Schema::create('ticket_attachments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $t->foreignId('comment_id')->nullable()->constrained('ticket_comments')->nullOnDelete();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->string('file_path');
            $t->string('original_name');
            $t->string('mime_type')->nullable();
            $t->unsignedBigInteger('file_size')->nullable();
            $t->timestamps();
        });
        Schema::create('ticket_histories', function (Blueprint $t) {
            $t->id();
            $t->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->string('action', 50);
            $t->string('description')->nullable();
            $t->string('old_value')->nullable();
            $t->string('new_value')->nullable();
            $t->timestamps();
        });
        Schema::create('ticket_ratings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->unsignedTinyInteger('rating');
            $t->string('comment')->nullable();
            $t->timestamps();
            $t->unique('ticket_id');
        });
        Schema::create('ticket_notifications', function (Blueprint $t) {
            $t->id();
            $t->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->string('title');
            $t->string('message')->nullable();
            $t->string('url')->nullable();
            $t->boolean('is_read')->default(false);
            $t->timestamps();
            $t->index(['user_id', 'is_read']);
        });
        Schema::create('activity_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->string('ip', 50)->nullable();
            $t->string('browser', 50)->nullable();
            $t->string('action', 100);
            $t->string('description')->nullable();
            $t->string('model', 100)->nullable();
            $t->unsignedBigInteger('model_id')->nullable();
            $t->text('old_value')->nullable();
            $t->text('new_value')->nullable();
            $t->timestamp('created_at');
        });
        $this->buildLegacyStubs();
    }

    /**
     * Layout bersama (layouts/app) dan partial sidebar memuat query dari modul
     * lama (meeting, pembayaran, aset). Tabel dibuat kosong agar query count /
     * whereHas berhasil dan blok @foreach tidak tereksekusi.
     */
    protected function buildLegacyStubs(): void
    {
        Schema::create('rooms', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->timestamps();
        });
        Schema::create('meetings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('requester_id')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();
            $t->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $t->string('title');
            $t->string('status', 30)->nullable();
            $t->date('meeting_date')->nullable();
            $t->string('start_time', 10)->nullable();
            $t->string('end_time', 10)->nullable();
            $t->timestamps();
        });
        Schema::create('meeting_invitations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('meeting_id')->constrained('meetings')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->boolean('is_read')->default(false);
            $t->timestamp('read_at')->nullable();
            $t->timestamps();
        });
        Schema::create('weekly_meetings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $t->string('title');
            $t->timestamps();
        });
        Schema::create('weekly_meeting_sessions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('weekly_meeting_id')->constrained('weekly_meetings')->cascadeOnDelete();
            $t->date('session_date')->nullable();
            $t->string('start_time', 10)->nullable();
            $t->string('end_time', 10)->nullable();
            $t->string('status', 20)->nullable();
            $t->timestamps();
        });
        Schema::create('weekly_meeting_invitations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('session_id')->constrained('weekly_meeting_sessions')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->boolean('is_read')->default(false);
            $t->timestamp('read_at')->nullable();
            $t->timestamps();
        });
        Schema::create('vehicle_pajak_requests', function (Blueprint $t) {
            $t->id();
            $t->string('status', 30)->nullable();
            $t->timestamps();
        });
        Schema::create('wifi_payments', function (Blueprint $t) {
            $t->id();
            $t->string('status', 30)->nullable();
            $t->string('requested_by')->nullable();
            $t->date('masa_tenggang')->nullable();
            $t->timestamps();
        });
        foreach (['pembayaran_aset_digital', 'pembayaran_ipl_ruko', 'pembayaran_aset_mes', 'pembayaran_aset_tim'] as $tbl) {
            Schema::create($tbl, function (Blueprint $t) {
                $t->id();
                $t->string('status', 30)->nullable();
                $t->string('requested_by')->nullable();
                $t->date('jatuh_tempo')->nullable();
                $t->timestamps();
            });
        }
        Schema::create('aset_tim', function (Blueprint $t) {
            $t->id();
            $t->string('tim')->nullable();
            $t->unsignedBigInteger('penanggung_jawab')->nullable();
            $t->timestamps();
        });
        Schema::create('aset_mes', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('penanggung_jawab')->nullable();
            $t->timestamps();
        });
    }
}
