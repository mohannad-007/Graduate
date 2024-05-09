<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //جدول العمليات المطلوبة
    {
        Schema::create('required_operations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('types_of_cases_id')->unsigned();
            $table->integer('number_of_cases');
            $table->date('date');
            $table->enum('chapter',['one','two']);
            $table->timestamps();

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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('required_operations');
    }
};
