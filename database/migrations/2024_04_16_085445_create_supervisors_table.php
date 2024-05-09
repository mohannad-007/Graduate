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
        Schema::create('supervisors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id')->unsigned()->nullable();
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->enum('type', ['master', 'doctor'])->nullable();
            $table->timestamps();

            $table
                ->foreign('student_id')
                ->references('id')
                ->on('student')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisors');
    }
};



