<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //الاحالات
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('patient_cases_id')->unsigned();
            $table->enum('type_of_refarrals',['converted_from_section','converted_from_student']);
            $table->enum('status_of_refarrals',['confirmed','sorry','before_confirmation']);
            $table->enum('status_done',['finished','not_finished']);
            $table->timestamps();

            $table
                ->foreign('student_id')
                ->references('id')
                ->on('student')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table
                ->foreign('patient_cases_id')
                ->references('id')
                ->on('patient_cases')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
