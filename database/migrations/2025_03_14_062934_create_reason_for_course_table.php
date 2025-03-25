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
        Schema::create('reason_for_course', function (Blueprint $table) {
            $table->unsignedBigInteger('reason_id')->autoIncrement();
            $table->primary('reason_id');
            $table->unsignedBigInteger('graduate_id');
            $table->foreign('graduate_id')->references('graduate_id')->on('graduates')->cascadeOnDelete();
            $table->enum('type', ['undergraduate', 'graduate'])->index();
            $table->text('reason')->default('No particular choice or no better idea');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reason_for_course');
    }
};