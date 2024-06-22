<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //الادوات المخبرية المطلوبة
    {
        Schema::create('laboratory_tools_required', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->unsigned();
            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('session_id')->unsigned();
            $table->bigInteger('laboratoryTools_id')->unsigned();
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
                ->foreign('session_id')
                ->references('id')
                ->on('sessions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('laboratoryTools_id')
                ->references('id')
                ->on('student_laboratory_tools')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratory_tools_requireds');
    }
};
