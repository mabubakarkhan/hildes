<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_published')->default(false);

            $table->string('hero_headline')->nullable();
            $table->text('hero_content')->nullable();
            $table->string('hero_image')->nullable();

            $table->string('body_heading')->nullable();
            $table->text('body_content')->nullable();
            $table->string('body_image')->nullable();

            $table->longText('deliverables_text')->nullable();
            $table->longText('process_text')->nullable();
            $table->longText('global_focus_text')->nullable();
            $table->longText('faq_text')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_pages');
    }
};
