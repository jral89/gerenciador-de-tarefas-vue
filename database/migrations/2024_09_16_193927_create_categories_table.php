<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        DB::table('categories')->insert([
            ['id' => 1, 'title' => 'Trabalho', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'title' => 'Pessoal', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'title' => 'Estudo', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'title' => 'Saúde', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'title' => 'Lazer', 'created_at' => now(), 'updated_at' => now()],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
