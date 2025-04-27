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
        Schema::create('reasons', function (Blueprint $table) {
            $table->integer('reason_id')->autoIncrement();
            $table->primary('reason_id');
            $table->integer('graduate_id')->nullable();
            $table->foreign('graduate_id')->references('graduate_id')->on('graduates')->cascadeOnDelete();
            $table->enum('type', [
                'pursue_study_reason',
                'unemployment_reason',
                'job_retention_reason',
                'job_acceptance_reason',
                'job_change_reason',
                'suggestion'
            ])
                ->nullable();
            $table->string('reason', 100)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reasons');
    }
};