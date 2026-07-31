<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketSla;
use App\Models\TicketTeamMember;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use DatabaseTransactions;

    protected User $requester;

    protected User $teamMember;

    protected User $teamLeader;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->buildSchemaIfNeeded();

        $team = Team::create(['name' => 'Divisi IT']);

        $this->requester = User::create([
            'name' => 'Karyawan Test',
            'username' => 'karyawan_test',
            'email' => 'karyawan@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'team_id' => $team->id,
        ]);

        $this->teamMember = User::create([
            'name' => 'Teknisi IT',
            'username' => 'teknisi_it',
            'email' => 'teknisi@test.com',
            'password' => bcrypt('password'),
            'role' => 'koordinator',
            'team_id' => $team->id,
        ]);

        $this->teamLeader = User::create([
            'name' => 'Leader IT',
            'username' => 'leader_it',
            'email' => 'leader@test.com',
            'password' => bcrypt('password'),
            'role' => 'koordinator',
            'team_id' => $team->id,
        ]);

        $this->admin = User::create([
            'name' => 'Admin Test',
            'username' => 'admin_test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        TicketTeamMember::create(['user_id' => $this->teamMember->id, 'is_leader' => false]);
        TicketTeamMember::create(['user_id' => $this->teamLeader->id, 'is_leader' => true]);

        TicketSla::create(['priority' => 'low', 'duration_minutes' => 4320]);
        TicketSla::create(['priority' => 'medium', 'duration_minutes' => 1440]);
        TicketSla::create(['priority' => 'high', 'duration_minutes' => 240]);
        TicketSla::create(['priority' => 'urgent', 'duration_minutes' => 120]);

        TicketCategory::create(['name' => 'Hardware']);
    }

    /**
     * Migrasi repositori memakai sintaks MySQL (ALTER ... MODIFY COLUMN) yang
     * tidak kompatibel SQLite, jadi skema dibangun manual untuk keperluan test.
     * Skema dibangun setiap test di dalam transaksi DatabaseTransactions,
     * sehingga otomatis dibersihkan setelah setiap test berakhir.
     */
    protected function buildSchemaIfNeeded(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->nullable();
            $table->string('password');
            $table->string('role', 30)->default('user');
            $table->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->string('avatar')->nullable();
            $table->string('theme', 20)->nullable();
            $table->boolean('email_notifications')->default(true);
            $table->boolean('app_notifications')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type', 50)->nullable();
            $table->string('title');
            $table->string('message')->nullable();
            $table->string('url')->nullable();
            $table->string('dedup_key')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_sla', function (Blueprint $table) {
            $table->id();
            $table->string('priority', 20)->unique();
            $table->unsignedInteger('duration_minutes');
            $table->string('label')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_leader')->default(false);
            $table->timestamps();
            $table->unique('user_id');
        });

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number', 30)->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('ticket_categories')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title', 100);
            $table->text('description');
            $table->string('location', 100);
            $table->string('department', 100)->nullable();
            $table->string('position', 100)->nullable();
            $table->string('priority', 20)->default('medium');
            $table->string('status', 30)->default('open')->index();
            $table->timestamp('sla_due_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['user_id', 'status']);
            $table->index(['assigned_to', 'status']);
        });

        Schema::create('ticket_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('comment');
            $table->timestamps();
        });

        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->foreignId('comment_id')->nullable()->constrained('ticket_comments')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('file_path');
            $table->string('original_name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 50);
            $table->string('description')->nullable();
            $table->string('old_value')->nullable();
            $table->string('new_value')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->unique('ticket_id');
        });

        Schema::create('ticket_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('message')->nullable();
            $table->string('url')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            $table->index(['user_id', 'is_read']);
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('ip', 50)->nullable();
            $table->string('browser', 50)->nullable();
            $table->string('action', 100);
            $table->string('description')->nullable();
            $table->string('model', 100)->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->timestamp('created_at');
        });
    }

    protected function ticketData(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Laptop tidak menyala',
            'category_id' => TicketCategory::first()->id,
            'description' => 'Laptop di ruang meeting tidak bisa dinyalakan.',
            'location' => 'Lantai 1',
            'priority' => 'high',
        ], $overrides);
    }

    public function test_requester_can_create_ticket_and_see_it(): void
    {
        $this->actingAs($this->requester)
            ->post(route('ticket.store'), $this->ticketData())
            ->assertRedirect();

        $ticket = Ticket::first();

        $this->assertNotNull($ticket);
        $this->assertSame('open', $ticket->status);
        $this->assertSame('high', $ticket->priority);
        $this->assertMatchesRegularExpression('/^TK-\d{8}-\d{4}$/', $ticket->ticket_number);
        $this->assertSame(240, $ticket->slaDurationMinutes());
        $this->assertTrue($ticket->sla_due_at->greaterThan(now()));
        $this->assertSame('Karyawan Test', $ticket->requester->name);

        $this->actingAs($this->requester)
            ->get(route('ticket.my'))
            ->assertSee($ticket->ticket_number);
    }

    public function test_ticket_number_sequence_increments(): void
    {
        $this->actingAs($this->requester)->post(route('ticket.store'), $this->ticketData());
        $this->actingAs($this->requester)->post(route('ticket.store'), $this->ticketData());

        $numbers = Ticket::orderBy('id')->pluck('ticket_number');

        $this->assertCount(2, $numbers);
        $this->assertStringEndsWith('0001', $numbers[0]);
        $this->assertStringEndsWith('0002', $numbers[1]);
    }

    public function test_non_team_user_cannot_access_manage_pages(): void
    {
        $this->actingAs($this->requester)
            ->get(route('ticket.index'))
            ->assertForbidden();

        $this->actingAs($this->requester)
            ->get(route('ticket.reports'))
            ->assertForbidden();
    }

    public function test_team_member_can_take_ticket(): void
    {
        $ticket = Ticket::factory()->create(['user_id' => $this->requester->id]);

        $this->actingAs($this->teamMember)
            ->post(route('ticket.take', $ticket))
            ->assertRedirect();

        $ticket->refresh();

        $this->assertSame('assigned', $ticket->status);
        $this->assertSame($this->teamMember->id, $ticket->assigned_to);
    }

    public function test_leader_can_assign_technician(): void
    {
        $ticket = Ticket::factory()->create(['user_id' => $this->requester->id]);

        $this->actingAs($this->teamLeader)
            ->post(route('ticket.assign', $ticket), ['assigned_to' => $this->teamMember->id])
            ->assertRedirect();

        $ticket->refresh();

        $this->assertSame($this->teamMember->id, $ticket->assigned_to);
    }

    public function test_non_leader_cannot_assign(): void
    {
        $ticket = Ticket::factory()->create(['user_id' => $this->requester->id]);

        $this->actingAs($this->teamMember)
            ->post(route('ticket.assign', $ticket), ['assigned_to' => $this->teamMember->id])
            ->assertForbidden();
    }

    public function test_team_can_update_status_flow(): void
    {
        $ticket = Ticket::factory()->create([
            'user_id' => $this->requester->id,
            'assigned_to' => $this->teamMember->id,
            'status' => 'assigned',
        ]);

        $this->actingAs($this->teamMember)
            ->patch(route('ticket.status', $ticket), ['status' => 'in_progress'])
            ->assertRedirect();

        $this->actingAs($this->teamMember)
            ->post(route('ticket.resolve', $ticket))
            ->assertRedirect();

        $ticket->refresh();

        $this->assertSame('resolved', $ticket->status);
        $this->assertNotNull($ticket->resolved_at);
    }

    public function test_owner_can_close_and_rate_ticket(): void
    {
        $ticket = Ticket::factory()->create([
            'user_id' => $this->requester->id,
            'assigned_to' => $this->teamMember->id,
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);

        $this->actingAs($this->requester)
            ->post(route('ticket.close', $ticket))
            ->assertRedirect();

        $ticket->refresh();

        $this->assertSame('closed', $ticket->status);
        $this->assertNotNull($ticket->closed_at);

        $this->actingAs($this->requester)
            ->post(route('ticket.rate', $ticket), ['rating' => 5, 'comment' => 'Bagus!'])
            ->assertRedirect();

        $this->assertSame(5, $ticket->rating->rating);
        $this->assertSame('Bagus!', $ticket->rating->comment);
    }

    public function test_owner_can_reopen_closed_ticket(): void
    {
        $ticket = Ticket::factory()->create([
            'user_id' => $this->requester->id,
            'assigned_to' => $this->teamMember->id,
            'status' => 'closed',
            'resolved_at' => now(),
            'closed_at' => now(),
        ]);

        $this->actingAs($this->requester)
            ->post(route('ticket.reopen', $ticket), ['note' => 'Masih bermasalah'])
            ->assertRedirect();

        $ticket->refresh();

        $this->assertSame('reopened', $ticket->status);
        $this->assertNull($ticket->closed_at);
    }

    public function test_invalid_status_transition_rejected(): void
    {
        $ticket = Ticket::factory()->create([
            'user_id' => $this->requester->id,
            'assigned_to' => $this->teamMember->id,
            'status' => 'open',
        ]);

        $this->actingAs($this->teamMember)
            ->patch(route('ticket.status', $ticket), ['status' => 'resolved'])
            ->assertRedirect();

        $ticket->refresh();

        $this->assertSame('open', $ticket->status);
    }

    public function test_user_cannot_view_others_ticket(): void
    {
        $other = User::create([
            'name' => 'User Lain',
            'username' => 'user_lain',
            'email' => 'other@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $ticket = Ticket::factory()->create(['user_id' => $other->id]);

        $this->actingAs($this->requester)
            ->get(route('ticket.show', $ticket))
            ->assertForbidden();
    }

    public function test_ticket_comment_creates_history(): void
    {
        $ticket = Ticket::factory()->create([
            'user_id' => $this->requester->id,
            'assigned_to' => $this->teamMember->id,
        ]);

        $this->actingAs($this->teamMember)
            ->post(route('ticket.comment', $ticket), ['comment' => 'Sedang kami periksa.'])
            ->assertRedirect();

        $this->assertDatabaseHas('ticket_comments', [
            'ticket_id' => $ticket->id,
            'user_id' => $this->teamMember->id,
            'comment' => 'Sedang kami periksa.',
        ]);

        $this->assertDatabaseHas('ticket_histories', [
            'ticket_id' => $ticket->id,
            'action' => 'comment',
        ]);

        $this->assertDatabaseHas('ticket_notifications', [
            'ticket_id' => $ticket->id,
            'user_id' => $this->requester->id,
        ]);
    }

    public function test_admin_is_implicitly_ticket_team(): void
    {
        $this->assertTrue($this->admin->isTicketTeam());
        $this->assertTrue($this->admin->isTicketLeader());
    }

    public function test_service_rejects_invalid_transition(): void
    {
        $ticket = Ticket::factory()->create([
            'user_id' => $this->requester->id,
            'status' => 'closed',
        ]);

        $this->expectException(\InvalidArgumentException::class);

        app(TicketService::class)->updateStatus($ticket, 'in_progress', $this->teamMember);
    }
}
