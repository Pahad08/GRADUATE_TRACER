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
            $table->integer('graduate_id')->autoIncrement();
            $table->primary('graduate_id');
            $table->string('f_name', length: 100)->nullable()->index();
            $table->string('name_extension', length: 100)->nullable()->index();
            $table->string('l_name', length: 100)->nullable()->index();
            $table->string('permanent_address', length: 100)->nullable();
            $table->string('email_address', length: 100)->nullable()->index();
            $table->string('contact_number', length: 100)->nullable();
            $table->string('civil_status', length: 100)->nullable()->index();
            $table->enum('sex', ['male', 'female'])->nullable()->index();
            $table->date('birthdate')->nullable();
            $table->string('region', length: 100)->default('REGION 12')->nullable();
            $table->string('province', length: 100)->nullable();
            $table->string('location_of_residence', length: 100)->nullable();
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