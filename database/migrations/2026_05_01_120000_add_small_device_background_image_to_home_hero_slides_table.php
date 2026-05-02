<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_hero_slides', function (Blueprint $table): void {
            $table->string('small_device_background_image')->nullable()->after('background_image');
        });
    }

    public function down(): void
    {
        Schema::table('home_hero_slides', function (Blueprint $table): void {
            $table->dropColumn('small_device_background_image');
        });
    }
};
