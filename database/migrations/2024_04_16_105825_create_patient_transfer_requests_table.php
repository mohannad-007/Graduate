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
        Schema::create('patient_transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('referrals_id')->unsigned();
            $table->string('note');
            $table->timestamps();

            $table
                ->foreign('student_id')
                ->references('id')
                ->on('student')
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
        Schema::dropIfExists('patient_transfer_requests');
    }
};
