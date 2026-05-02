<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_pages', function (Blueprint $table) {
            $table->unsignedInteger('display_order')->default(0)->after('is_published');
        });

        $services = DB::table('service_pages')
            ->orderBy('display_order')
            ->orderBy('id')
            ->pluck('id');

        foreach ($services as $index => $id) {
            DB::table('service_pages')
                ->where('id', $id)
                ->update(['display_order' => $index + 1]);
        }
    }

    public function down(): void
    {
        Schema::table('service_pages', function (Blueprint $table) {
            $table->dropColumn('display_order');
        });
    }
};
