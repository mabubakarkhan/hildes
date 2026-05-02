<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('career_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('department')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('location')->nullable();
            $table->string('work_mode')->nullable();
            $table->string('experience_level')->nullable();
            $table->unsignedSmallInteger('min_experience_years')->default(0);
            $table->unsignedSmallInteger('max_experience_years')->nullable();
            $table->text('education_requirements')->nullable();
            $table->longText('required_skills')->nullable();
            $table->longText('responsibilities')->nullable();
            $table->longText('description')->nullable();
            $table->string('salary_range')->nullable();
            $table->enum('status', ['draft', 'open', 'closed'])->default('open');
            $table->date('deadline')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_jobs');
    }
};
