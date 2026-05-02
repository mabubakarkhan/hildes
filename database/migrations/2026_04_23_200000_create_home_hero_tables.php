<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_hero_settings', function (Blueprint $table): void {
            $table->id();
            $table->unsignedSmallInteger('aspect_ratio_width')->default(16);
            $table->unsignedSmallInteger('aspect_ratio_height')->default(9);
            $table->timestamps();
        });

        Schema::create('home_hero_slides', function (Blueprint $table): void {
            $table->id();
            $table->string('pre_title_span')->nullable();
            $table->string('pre_title_rest')->nullable();
            $table->text('title')->nullable();
            $table->text('disc')->nullable();
            $table->string('button_label')->nullable();
            $table->string('button_url')->nullable();
            $table->string('background_image')->nullable();
            $table->string('background_image_original_name')->nullable();
            $table->string('style_variant', 20)->default('default');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_hero_slides');
        Schema::dropIfExists('home_hero_settings');
    }
};
