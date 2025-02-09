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
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('obat');
            $table->string('pemakaian');
            $table->foreignId('kategori_id')->constrained(
                table: 'categories', indexName: 'obat_katek_id'
            );
            $table->foreignId('satuan_id')->constrained(
                table: 'satuans', indexName: 'obat_sat_id'
            );
            $table->string('berat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
