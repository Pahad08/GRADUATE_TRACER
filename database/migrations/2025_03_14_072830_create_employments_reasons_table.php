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
        Schema::create('employment_reasons', function (Blueprint $table) {
            $table->unsignedBigInteger('reason_id')->autoIncrement();
            $table->primary('reason_id');
            $table->unsignedBigInteger('employment_status_id')->nullable();
            $table->foreign('employment_status_id')->references('employment_status_id')->on('employment_status')->cascadeOnDelete();
            $table->enum('reason_type', ['unemployment', 'job_retention', 'job_acceptance', 'job_change'])->nullable()->index();
            $table->text('reason')->nullable();
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
