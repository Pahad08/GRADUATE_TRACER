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
        Schema::create('job_details', function (Blueprint $table) {
            $table->unsignedBigInteger('job_detail_id')->autoIncrement();
            $table->primary('job_detail_id');
            $table->unsignedBigInteger('employment_status_id')->nullable();
            $table->foreign('employment_status_id')->references('employment_status_id')->on('employment_status')->cascadeOnDelete();
            $table->enum('job_type', ['learned_skill', 'job_search_method', 'job_search_duration', 'job_duration'])->nullable();
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('first_job_details');
    }
};
