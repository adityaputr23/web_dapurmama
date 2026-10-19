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
        Schema::create('settings', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('key')->unique();
            $blueprint->text('value')->nullable();
            $blueprint->timestamps();
        });

        // Seed default values
        \Illuminate\Support\Facades\DB::table('settings')->insert([
            [
                'key' => 'shop_name',
                'value' => 'Dapur Bunda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '+62 812-3456-7890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'shop_address',
                'value' => 'Jl. Mawar Indah No. 12, Jakarta Selatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'shop_open_hours',
                'value' => 'Setiap Hari: 08:00 - 20:00 WIB',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
