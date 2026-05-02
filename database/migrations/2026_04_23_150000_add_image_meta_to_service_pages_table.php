<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_pages', function (Blueprint $table) {
            $table->string('hero_image_alt')->nullable()->after('hero_image');
            $table->string('hero_image_original_name')->nullable()->after('hero_image_alt');
            $table->string('body_image_alt')->nullable()->after('body_image');
            $table->string('body_image_original_name')->nullable()->after('body_image_alt');
        });
    }

    public function down(): void
    {
        Schema::table('service_pages', function (Blueprint $table) {
            $table->dropColumn([
                'hero_image_alt',
                'hero_image_original_name',
                'body_image_alt',
                'body_image_original_name',
            ]);
        });
    }
};
