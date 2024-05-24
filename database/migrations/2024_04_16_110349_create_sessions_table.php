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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supervisor_id')->unsigned();
            $table->bigInteger('clinic_id')->unsigned();
            $table->bigInteger('referrals_id')->unsigned();
            $table->integer('supervisor_evaluation');
            $table->string('supervisor_notes');
            $table->date('history');
            $table->time('timeSession');
            $table->string('student_notes');
            $table->enum('status_of_session',['complete','not_complete','last_refarral','didnt_come']);
            $table->softDeletes();
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

            $table
                ->foreign('referrals_id')
                ->references('id')
                ->on('referrals')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
