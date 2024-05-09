<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()//الامراض المسبقة للمريض
    {
        Schema::create('patient_diseases', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->unsigned();
            $table->bigInteger('preexisting_disease_id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table
                ->foreign('patient_id')
                ->references('id')
                ->on('patient')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('preexisting_disease_id')
                ->references('id')
                ->on('preexisting_diseases')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_diseases');
    }
};
