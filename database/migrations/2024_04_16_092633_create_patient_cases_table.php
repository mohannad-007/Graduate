<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //حالات المريض
    {
        Schema::create('patient_cases', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->unsigned();
            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('types_of_cases_id')->unsigned();
            $table->bigInteger('diagnosis_appointments_id')->unsigned();
            $table->string('details_of_cases');
            $table->timestamps();

            $table
                ->foreign('patient_id')
                ->references('id')
                ->on('patient')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table
                ->foreign('student_id')
                ->references('id')
                ->on('student')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table
                ->foreign('types_of_cases_id')
                ->references('id')
                ->on('types_of_cases')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table
                ->foreign('diagnosis_appointments_id')
                ->references('id')
                ->on('diagnosis_appointments')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_cases');
    }
};
