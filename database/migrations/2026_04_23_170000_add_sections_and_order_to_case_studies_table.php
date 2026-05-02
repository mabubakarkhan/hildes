<?php

use App\Models\CaseStudy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('case_studies', function (Blueprint $table): void {
            $table->longText('sections_json')->nullable()->after('detail_content');
            $table->unsignedInteger('display_order')->default(0)->after('is_published');
        });

        $records = CaseStudy::query()->orderBy('id')->get(['id']);
        foreach ($records as $index => $record) {
            CaseStudy::query()->whereKey($record->id)->update(['display_order' => $index + 1]);
        }
    }

    public function down(): void
    {
        Schema::table('case_studies', function (Blueprint $table): void {
            $table->dropColumn(['sections_json', 'display_order']);
        });
    }
};

