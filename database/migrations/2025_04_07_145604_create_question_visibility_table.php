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
        Schema::create(
            'question_visibility',
            function (Blueprint $table) {
                $table->integer('question_id')->autoIncrement();
                $table->primary('question_id');
                $table->string('section_name', 100)->nullable();
                $table->string('question_key', 100)->unique()->nullable();
                $table->integer('question_order')->nullable();
                $table->boolean('is_visible')->default('1');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_visibility');
    }
};