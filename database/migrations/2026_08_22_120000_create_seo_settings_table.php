<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('default_meta_title')->nullable();
            $table->text('default_meta_description')->nullable();
            $table->string('default_meta_keywords')->nullable();
            $table->string('default_meta_author')->nullable();
            $table->string('default_robots_directive')->default('index,follow');
            $table->string('og_site_name')->default('HilDes');
            $table->string('default_og_type')->default('website');
            $table->string('default_og_image')->nullable();
            $table->string('default_twitter_image')->nullable();
            $table->string('twitter_card')->default('summary_large_image');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_settings');
    }
};
