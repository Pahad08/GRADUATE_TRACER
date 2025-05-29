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
        Schema::create('academic_years', function (Blueprint $table) {
            $table->integer('academic_year_id')->autoIncrement();
            $table->primary('academic_year_id');
            $table->year('start_year');
            $table->year('end_year');
            $table->timestamps();
        });

        Schema::table('educational_backgrounds', function (Blueprint $table) {
            $table->dropColumn('year_graduated');
            $table->integer('academic_year_id')->nullable()->after('hei_id');
            $table->foreign('academic_year_id')->references('academic_year_id')->on('academic_years')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_years');
    }
};