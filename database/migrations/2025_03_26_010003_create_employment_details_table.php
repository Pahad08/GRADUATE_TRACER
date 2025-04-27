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
        Schema::create('employment_details', function (Blueprint $table) {
            $table->integer('employment_details_id')->autoIncrement();
            $table->primary('employment_details_id');
            $table->integer('employment_status_id')->nullable();
            $table->foreign('employment_status_id')->references('employment_status_id')->on('employment_status')->cascadeOnDelete();
            $table->enum('present_employment_status', ['Regular/permanent', 'Contractual', 'Temporary', 'Self employed', 'Casual'])->nullable();
            $table->enum('occupation', [
                'Officials of Government and Special-Interest Organizations',
                'Professionals',
                'Technicians and Associate Professionals',
                'Clerks',
                'Service workers and Shop and Market Sales Workers',
                'Farmers, Forestry Workers and Fishermen',
                'Trades and Related Workers',
                'Plant and machine Operators and Assemblers',
                'Laborers and Unskilled Workers',
                'Special Occupation'
            ])->nullable()->index();
            $table->string('company_name', length: 100)->nullable()->index();
            $table->enum('industry', [
                'Agriculture',
                'Fishing',
                'Mining',
                'Manufacturing',
                'Utilities',
                'Construction',
                'Wholesale/Retail',
                'Hotels/Restaurants',
                'Transport/Communication',
                'Finance',
                'Real Estate',
                'Public Administration',
                'Education',
                'Health/Social Work',
                'Other Services',
                'Private Households',
                'Extra-territorial'
            ])->nullable()->index();
            $table->enum('work_location', ['local', 'abroad'])->nullable()->index();
            $table->boolean('is_first_job')->index();
            $table->boolean('is_curriculum_relevant_to_job')->index();
            $table->boolean('is_related_to_course')->index();
            $table->enum('first_job_level', ['Rank/Clerical', 'Professional/Technical/Supervisory', 'Managerial/Executive'])->index()->nullable();
            $table->enum('current_job_level', ['Rank/Clerical', 'Professional/Technical/Supervisory', 'Managerial/Executive'])->index()->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employment_details');
    }
};
