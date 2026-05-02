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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('education_level')->nullable();
            $table->unsignedSmallInteger('experience_years')->default(0);
            $table->longText('skills')->nullable();
            $table->longText('cover_letter')->nullable();
            $table->string('cv_file')->nullable();
            $table->enum('status', ['new', 'accepted', 'rejected'])->default('new');
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
