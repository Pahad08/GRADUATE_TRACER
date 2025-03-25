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
        Schema::create('suggestions', function (Blueprint $table) {
            $table->unsignedBigInteger('suggestion_id')->autoIncrement();
            $table->primary('suggestion_id');
            $table->unsignedBigInteger('graduate_id');
            $table->foreign('graduate_id')->references('graduate_id')->on('graduates')->cascadeOnDelete();
            $table->text('suggestions');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestions');
    }
};