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
        Schema::create('question_options', function (Blueprint $table) {
            $table->integer('question_option_id')->autoIncrement();
            $table->primary('question_option_id');
            $table->integer('custom_question_id');
            $table->foreign('custom_question_id')->references('custom_question_id')->on('custom_questions')->cascadeOnDelete();
            $table->string('option_text', length: 100);
            $table->string('option_value', length: 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_options');
    }
};