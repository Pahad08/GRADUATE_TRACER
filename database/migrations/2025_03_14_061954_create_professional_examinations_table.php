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
        Schema::create('professional_examinations', function (Blueprint $table) {
            $table->unsignedBigInteger('professional_examination_id')->autoIncrement();
            $table->primary('professional_examination_id');
            $table->unsignedBigInteger('graduate_id');
            $table->foreign('graduate_id')->references('graduate_id')->on('graduates')->cascadeOnDelete();
            $table->string('name_of_examination', length: 100)->index();
            $table->date('date_taken');
            $table->string('rating', length: 100);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_examinations');
    }
};