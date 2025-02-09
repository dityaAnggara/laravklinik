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
        Schema::create('reseps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_id')->nullable()->constrained(
                table: 'obats', indexName: 'resep_obat_id'
            );
            $table->foreignId('daftar_id')->nullable()->constrained(
                table: 'users', indexName: 'dokter_resep_id'
            );
            $table->foreignId('apoteker_id')->nullable()->constrained(
                table: 'users', indexName: 'apotek_resep_id'
            );
            $table->string('note_obat')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseps');
    }
};
