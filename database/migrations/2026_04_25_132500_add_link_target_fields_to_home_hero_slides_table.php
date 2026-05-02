<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_hero_slides', function (Blueprint $table): void {
            $table->string('link_type', 30)->default('custom')->after('button_label');
            $table->unsignedBigInteger('linked_service_id')->nullable()->after('button_url');
            $table->unsignedBigInteger('linked_case_study_id')->nullable()->after('linked_service_id');
        });
    }

    public function down(): void
    {
        Schema::table('home_hero_slides', function (Blueprint $table): void {
            $table->dropColumn([
                'link_type',
                'linked_service_id',
                'linked_case_study_id',
            ]);
        });
    }
};
