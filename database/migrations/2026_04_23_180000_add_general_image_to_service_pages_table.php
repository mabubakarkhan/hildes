<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_pages', function (Blueprint $table) {
            $table->string('general_image')->nullable()->after('is_published');
            $table->string('general_image_alt')->nullable()->after('general_image');
            $table->string('general_image_original_name')->nullable()->after('general_image_alt');
        });
    }

    public function down(): void
    {
        Schema::table('service_pages', function (Blueprint $table) {
            $table->dropColumn([
                'general_image',
                'general_image_alt',
                'general_image_original_name',
            ]);
        });
    }
};
