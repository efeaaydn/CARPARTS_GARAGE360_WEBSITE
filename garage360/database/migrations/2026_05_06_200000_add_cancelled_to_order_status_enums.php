<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','confirmed','preparing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending'");
        DB::statement("ALTER TABLE order_status_logs MODIFY COLUMN status ENUM('pending','confirmed','preparing','shipped','delivered','cancelled') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','confirmed','preparing','shipped','delivered') NOT NULL DEFAULT 'pending'");
        DB::statement("ALTER TABLE order_status_logs MODIFY COLUMN status ENUM('pending','confirmed','preparing','shipped','delivered') NOT NULL");
    }
};
