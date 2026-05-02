<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('career_jobs', function (Blueprint $table) {
            $table->string('icon_class', 191)->nullable()->after('title');
        });

        DB::table('career_jobs')->where('slug', 'bdm-intern-may-2026')->update([
            'icon_class' => 'fa-solid fa-handshake',
        ]);
        DB::table('career_jobs')->where('slug', 'digital-marketing-intern-may-2026')->update([
            'icon_class' => 'fa-solid fa-bullhorn',
        ]);

        DB::table('career_jobs')->whereNull('icon_class')->update([
            'icon_class' => 'fa-solid fa-briefcase',
        ]);
    }

    public function down(): void
    {
        Schema::table('career_jobs', function (Blueprint $table) {
            $table->dropColumn('icon_class');
        });
    }
};
