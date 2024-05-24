<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //اوقات دوام المشرف
        // ملاحظة ال يوم حطيتو سترنغ بس المشرف
    {
        Schema::create('supervisor_times', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supervisor_id')->unsigned();
            $table->bigInteger('clinic_id')->unsigned();
            $table->string('day');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table
                ->foreign('supervisor_id')
                ->references('id')
                ->on('supervisors')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table
                ->foreign('clinic_id')
                ->references('id')
                ->on('clinics')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisor_times');
    }
};
