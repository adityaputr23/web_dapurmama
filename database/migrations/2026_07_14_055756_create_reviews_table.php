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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->integer('rating');
            $table->text('comment');
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });

        // Seed some starter premium reviews
        \Illuminate\Support\Facades\DB::table('reviews')->insert([
            [
                'name' => 'Siti Rahma',
                'email' => 'siti@gmail.com',
                'rating' => 5,
                'comment' => 'Nasi Tumpeng Mini nya enak sekali! Bumbunya meresap sampai ke dalam, ayam gorengnya juga empuk. Tempatnya bersih dan nyaman saat ambil pesanan.',
                'is_approved' => true,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'name' => 'Budi Setiawan',
                'email' => 'budi.s@yahoo.com',
                'rating' => 5,
                'comment' => 'Pesan Ayam Bakar Madu untuk acara keluarga, semua tamu memuji rasanya yang pas. Respon admin lewat chat cepat sekali dan pengiriman tepat waktu!',
                'is_approved' => true,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@gmail.com',
                'rating' => 4,
                'comment' => 'Rasa makanannya otentik rumahan banget, sambel bajaknya juara! Hanya saja kemarin agak antre saat pickup, tapi overall sangat memuaskan.',
                'is_approved' => true,
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
