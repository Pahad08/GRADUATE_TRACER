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
        Schema::create('graduates', function (Blueprint $table) {
            $table->unsignedBigInteger('graduate_id')->autoIncrement();
            $table->primary('graduate_id');
            $table->string('f_name', length: 100)->index();
            $table->string('l_name', length: 100)->index();
            $table->string('permanent_address', length: 100);
            $table->string('email_address', length: 100)->index();
            $table->string('contact_number', length: 100);
            $table->enum('civil_status', ['single', 'married', 'separated', 'single parent', 'widow'])->index();
            $table->enum('sex', ['male', 'female'])->index();
            $table->date('birthdate');
            $table->unsignedBigInteger('region_id');
            $table->foreign('region_id')->references('region_id')->on('regions')->cascadeOnDelete();
            $table->unsignedBigInteger('province_id');
            $table->foreign('province_id')->references('province_id')->on('provinces')->cascadeOnDelete();
            $table->enum('location_of_residence', ['City', 'Municipality']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graduates');
    }
};