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
            $table->integer('job_detail_id')->autoIncrement();
            $table->primary('job_detail_id');
            $table->integer('employment_details_id')->nullable();
            $table->foreign('employment_details_id')->references('employment_details_id')->on('employment_details')->cascadeOnDelete();
            $table->enum('type', [
                'college_skill',
                'first_job_search_method',
                'first_job_search_duration',
                'first_job_duration',
                'first_job_salary_range'
            ])
                ->nullable();
            $table->string('description', 100)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_details');
    }
};