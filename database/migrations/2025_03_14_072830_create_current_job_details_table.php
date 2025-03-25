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
        Schema::create('current_job_details', function (Blueprint $table) {
            $table->unsignedBigInteger('current_job_detail_id')->autoIncrement();
            $table->primary('current_job_detail_id');
            $table->enum('job_level', ['Rank/Clerical', 'Professional/Technical/Supervisory', 'Managerial/Executive'])->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_job_details');
    }
};