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
        Schema::create('educational_backgrounds', function (Blueprint $table) {
            $table->unsignedBigInteger('education_background_id')->autoIncrement();
            $table->primary('education_background_id');
            $table->unsignedBigInteger('graduate_id');
            $table->foreign('graduate_id')->references('graduate_id')->on('graduates')->cascadeOnDelete();
            $table->unsignedBigInteger('degree_id');
            $table->foreign('degree_id')->references('degree_id')->on('degrees')->cascadeOnDelete();
            $table->unsignedBigInteger('university_id');
            $table->foreign('university_id')->references('university_id')->on('universities')->cascadeOnDelete();
            $table->year('year_graduated')->index();
            $table->string('honors', length: 100)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};