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
        Schema::create('honors', function (Blueprint $table) {
            $table->integer('honor_id')->autoIncrement();
            $table->primary('honor_id');
            $table->integer('educational_background_id')->default(null)->nullable();
            $table->foreign('educational_background_id')->references('educational_background_id')->on('educational_backgrounds')->cascadeOnDelete();
            $table->string('honor', 100);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('educational_backgrounds', function (Blueprint $table) {
            // $table->dropColumn('honor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('honors');
    }
};