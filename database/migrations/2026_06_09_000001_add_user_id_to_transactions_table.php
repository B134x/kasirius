<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Guard: sebagian DB sudah punya kolom user_id dari sebelumnya.
        // hasColumn bikin migrasi ini aman dijalankan di DB lama maupun fresh install.
        if (Schema::hasColumn('transactions', 'user_id')) {
            return;
        }

        Schema::table('transactions', function (Blueprint $table) {
            // Kasir yang melakukan transaksi.
            // Nullable supaya transaksi lama (sebelum kolom ini ada) tetap valid.
            // nullOnDelete: kalau user dihapus, transaksi tetap ada tapi user_id jadi null.
            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('transactions', 'user_id')) {
            return;
        }

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
