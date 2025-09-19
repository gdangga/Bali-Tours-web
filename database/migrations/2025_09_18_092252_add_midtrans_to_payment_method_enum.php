<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modifikasi kolom untuk menambahkan 'midtrans'
        DB::statement("ALTER TABLE bookings MODIFY COLUMN payment_method ENUM('xendit', 'cash', 'midtrans') NOT NULL DEFAULT 'cash'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perintah untuk rollback (mengembalikan ke kondisi semula)
        DB::statement("ALTER TABLE bookings MODIFY COLUMN payment_method ENUM('xendit', 'cash') NOT NULL DEFAULT 'cash'");
    }
};