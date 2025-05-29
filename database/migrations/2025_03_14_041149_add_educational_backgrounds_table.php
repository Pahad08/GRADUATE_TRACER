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
            $table->string('degree', length: 100)->nullable();
            $table->string('hei', length: 100)->nullable();
            $table->year('year_graduated')->nullable()->index();
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
