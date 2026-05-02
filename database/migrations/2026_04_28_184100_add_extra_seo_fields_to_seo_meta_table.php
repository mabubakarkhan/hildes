<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seo_metas', function (Blueprint $table): void {
            $table->string('meta_author')->nullable()->after('meta_keywords');
            $table->string('meta_viewport')->nullable()->after('meta_author');
            $table->string('og_type')->nullable()->after('robots_directive');
            $table->string('og_url')->nullable()->after('og_description');
            $table->string('og_site_name')->nullable()->after('og_url');
            $table->string('twitter_card')->nullable()->after('twitter_image');
        });
    }

    public function down(): void
    {
        Schema::table('seo_metas', function (Blueprint $table): void {
            $table->dropColumn([
                'meta_author',
                'meta_viewport',
                'og_type',
                'og_url',
                'og_site_name',
                'twitter_card',
            ]);
        });
    }
};
