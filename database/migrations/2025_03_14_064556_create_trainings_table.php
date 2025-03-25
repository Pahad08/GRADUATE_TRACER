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
            $table->string('training_name', length: 100)->index();
            $table->string('duration_and_credits_earned', length: 100);
            $table->string('training_institution', length: 100);
            $table->text('reason_for_study');
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