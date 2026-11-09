<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // материалы
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('unit', 10)->default('м3'); // единицы обьема
            $table->timestamps();
        });

        // лог движения транспорта
        Schema::create('checkin_logs', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate', 20)->index(); // грнз
            $table->foreignId('material_id')->constrained('materials')->restrictOnDelete();
            $table->decimal('volume', 10, 2); // обьем
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // id охранника
            $table->timestamp('checked_in_at')->useCurrent()->index();
            $table->timestamps();
        });

        // фото
        Schema::create('checkin_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checkin_log_id')->constrained('checkin_logs')->cascadeOnDelete();
            $table->enum('type', ['vehicle', 'cargo', 'invoice']); // что фоткаем?
            $table->string('file_path', 512); // путь
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkin_photos');
        Schema::dropIfExists('checkin_logs');
        Schema::dropIfExists('materials');
    }
};
