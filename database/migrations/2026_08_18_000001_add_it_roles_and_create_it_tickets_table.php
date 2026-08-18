<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','koordinator','head_of_store','gm','hr','user','ceo','admin_ga','koordinator_it','staff_it') DEFAULT 'user'");

        Schema::create('it_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->foreignId('requester_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('assignee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->string('bukti_kendala')->nullable();
            $table->enum('kategori', ['perangkat', 'aplikasi', 'akun_akses', 'jaringan', 'lainnya'])->default('lainnya');
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi', 'mendesak'])->default('sedang');
            $table->enum('status', ['menunggu', 'diproses', 'dijeda', 'dilanjutkan', 'selesai', 'ditolak'])->default('menunggu');
            $table->text('catatan_it')->nullable();
            $table->text('alasan_jeda')->nullable();
            $table->text('feedback_atasan')->nullable();
            $table->timestamp('mulai_ditangani_at')->nullable();
            $table->timestamp('selesai_at')->nullable();
            $table->unsignedBigInteger('durasi_detik')->default(0);
            $table->timestamp('proses_mulai_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'assignee_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('it_tickets');

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','koordinator','head_of_store','gm','hr','user','ceo','admin_ga') DEFAULT 'user'");
    }
};
