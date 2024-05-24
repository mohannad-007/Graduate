<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //جدول مواعيد التشخيص
    {
        Schema::create('diagnosis_appointments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->unsigned();
            $table->bigInteger('student_id')->unsigned()->nullable();
            $table->bigInteger('diagnosis_id')->unsigned()->nullable();
            $table->date('date')->nullable();
            $table->time('timeDiagnosis')->nullable();
            $table->enum('order_status',['unacceptable','acceptable','pending','done_diagnosis'])->default('pending');
            $table->string('reason');
            $table->softDeletes();
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
                ->foreign('diagnosis_id')
                ->references('id')
                ->on('diagnoses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosis_appointments');
        Schema::table('diagnosis_appointments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
