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
            $table->unsignedBigInteger('employment_id');
            $table->unsignedBigInteger('first_job_detail_id');
            $table->unsignedBigInteger('current_job_detail_id');
            $table->foreign('first_job_detail_id')->references('first_job_detail_id')->on('first_job_details')->cascadeOnDelete();
            $table->foreign('current_job_detail_id')->references('current_job_detail_id')->on('current_job_details')->cascadeOnDelete();
            $table->foreign('employment_id')->references('employment_id')->on('employments')->cascadeOnDelete();
            $table->enum(
                'job_duration',
                [
                    'Less than a month',
                    '1 to 6 months',
                    '7 to 11 months',
                    '1 year to less than 2 years',
                    '2 years to less than 3 years',
                    '3 years to less than 4 years',
                    'Others'
                ]
            )->index();
            $table->enum(
                'job_search_duration',
                [
                    'Less than a month',
                    '1 to 6 months',
                    '7 to 11 months',
                    '1 year to less than 2 years',
                    '2 years to less than 3 years',
                    '3 years to less than 4 years',
                    'Others'
                ]
            )->index();
            $table->text('how_job_was_found');
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