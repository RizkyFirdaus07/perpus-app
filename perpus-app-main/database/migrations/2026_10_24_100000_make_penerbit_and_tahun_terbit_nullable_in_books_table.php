<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Penerbit dan tahun boleh kosong (sesuai validasi nullable pada BookController@store)
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('penerbit')->nullable()->change();
            $table->integer('tahun_terbit')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('penerbit')->nullable(false)->change();
            $table->integer('tahun_terbit')->nullable(false)->change();
        });
    }
};
