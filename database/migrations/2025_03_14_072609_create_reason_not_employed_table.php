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
        Schema::create('reason_not_employed', function (Blueprint $table) {
            $table->unsignedBigInteger('reason_id')->autoIncrement();
            $table->primary('reason_id');
            $table->unsignedBigInteger('employment_id');
            $table->text('reason');
            $table->softDeletes();
            $table->foreign('employment_id')->references('employment_id')->on('employments')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reason_not_employed');
    }
};