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
        Schema::create('daftarcheckups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained(
                table: 'pasiens', indexName: 'daftar_pas_id'
            );
            $table->foreignId('dokter_id')->constrained(
                table: 'users', indexName: 'dok_daf_id'
            );
            $table->string('status');
            $table->string('nomor_pendaftaran');
            $table->date('tanggalcheckups');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftarcheckups');
    }
};
