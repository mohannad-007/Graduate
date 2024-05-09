<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //انواع الحالات
    {
        Schema::create('types_of_cases', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('section_id')->unsigned();
            $table->string('type');
            $table->timestamps();

            $table
                ->foreign('section_id')
                ->references('id')
                ->on('sections')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types_of_cases');
    }
};
