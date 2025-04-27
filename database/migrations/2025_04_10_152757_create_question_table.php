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
        Schema::create('custom_questions', function (Blueprint $table) {
            $table->integer('custom_question_id')->autoIncrement();
            $table->primary('custom_question_id');
            $table->integer('question_id');
            $table->foreign('question_id')->references('question_id')->on('question_visibility')->cascadeOnDelete();
            $table->string('type', length: 100);
            $table->string('label', length: 100);
            $table->boolean('has_child');
            $table->boolean('is_analytics')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_questions');
    }
};
