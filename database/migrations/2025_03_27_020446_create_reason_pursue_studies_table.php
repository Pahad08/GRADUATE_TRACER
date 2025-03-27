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
        Schema::create('reason_pursue_studies', function (Blueprint $table) {
            $table->unsignedBigInteger('reason_pursue_study_id')->autoIncrement();
            $table->primary('reason_pursue_study_id');
            $table->unsignedBigInteger('graduate_id')->nullable();
            $table->foreign('graduate_id')->references('graduate_id')->on('graduates')->cascadeOnDelete();
            $table->text('reason_for_study')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reason_pursue_studies');
    }
};
