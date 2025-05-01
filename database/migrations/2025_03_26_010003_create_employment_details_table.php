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
        Schema::create('employment_details', function (Blueprint $table) {
            $table->integer('employment_details_id')->autoIncrement();
            $table->primary('employment_details_id');
            $table->integer('employment_status_id')->nullable();
            $table->foreign('employment_status_id')->references('employment_status_id')->on('employment_status')->cascadeOnDelete();
            $table->string('present_employment_status')->nullable();
            $table->string('occupation')->nullable()->index();
            $table->string('company_name', length: 100)->nullable()->index();
            $table->string('industry')->nullable()->index();
            $table->enum('work_location', ['local', 'abroad'])->nullable()->index();
            $table->boolean('is_first_job')->index();
            $table->boolean('is_curriculum_relevant_to_job')->index();
            $table->boolean('is_related_to_course')->index();
            $table->string('first_job_level')->index()->nullable();
            $table->string('current_job_level')->index()->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employment_details');
    }
};