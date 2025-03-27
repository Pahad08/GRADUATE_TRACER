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
        Schema::create('trainings', function (Blueprint $table) {
            $table->unsignedBigInteger('training_id')->autoIncrement();
            $table->primary('training_id');
            $table->unsignedBigInteger('graduate_id')->nullable();
            $table->foreign('graduate_id')->references('graduate_id')->on('graduates')->cascadeOnDelete();
            $table->string('training_name', length: 100)->nullable()->index();
            $table->string('duration_and_credits_earned', length: 100)->nullable();
            $table->string('training_institution', length: 100)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
