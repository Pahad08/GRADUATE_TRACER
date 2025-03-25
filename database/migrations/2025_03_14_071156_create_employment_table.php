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
        Schema::create('employments', function (Blueprint $table) {
            $table->unsignedBigInteger('employment_id')->autoIncrement();
            $table->primary('employment_id');
            $table->unsignedBigInteger('graduate_id');
            $table->foreign('graduate_id')->references('graduate_id')->on('graduates')->cascadeOnDelete();
            $table->enum('is_employed', ['yes', 'no', 'never employed'])->index();
            $table->enum('employment_status', ['Regular/Permanent', 'Contractual', 'Temporary', 'Self-employed', 'Casual']);
            $table->string('present_occupation', length: 100);
            $table->enum('major_line_of_business', [
                'Agriculture, Hunting and Forestry',
                'Fishing',
                'Mining and Quarrying',
                'Manufacturing',
                'Electricity, Gas and Water Supply',
                'Construction',
                'Wholesale and Retail Trade',
                'Hotels and Restaurants',
                'Transport Storage and Communication',
                'Financial Intermediation',
                'Real Estate, Renting and Business Activities',
                'Public Administration and Defense',
                'Education',
                'Health and Social Work',
                'Other Community, Social and Personal Service Activities',
                'Private Households with Employed Persons',
                'Extra-territorial Organizations and Bodies'
            ]);
            $table->enum('place_of_work', ['Local', 'Abroad']);
            $table->boolean('is_first_job');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employment');
    }
};