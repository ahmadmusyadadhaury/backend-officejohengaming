<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','koordinator','head_of_store','gm','hr','user','ceo','admin_ga') NOT NULL DEFAULT 'user'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','koordinator','head_of_store','gm','hr','user','ceo') NOT NULL DEFAULT 'user'");
    }
};
