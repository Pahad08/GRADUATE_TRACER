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
            $table->integer('educational_background_id')->autoIncrement();
            $table->primary('educational_background_id');
            $table->integer('graduate_id')->nullable();
            $table->foreign('graduate_id')->references('graduate_id')->on('graduates')->cascadeOnDelete();
            $table->integer('degree_id')->nullable();
            $table->foreign('degree_id')->references('degree_id')->on('degrees')->cascadeOnDelete();
            $table->integer('hei_id')->nullable();
            $table->foreign('hei_id')->references('hei_id')->on('hei')->cascadeOnDelete();
            $table->year('year_graduated')->nullable()->index();
            $table->string('honor', length: 100)->nullable();
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
