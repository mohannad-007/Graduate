<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('referral_required_operations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('referral_id')->unsigned();
            $table->bigInteger('required_operation_id')->unsigned();
            $table->date('date'); // إضافة عمود التاريخ
            $table->timestamps();

            // إضافة المفتاح الخارجي من جدول referrals
            $table
                ->foreign('referral_id')
                ->references('id')
                ->on('referrals')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // إضافة المفتاح الخارجي من جدول required_operations
            $table
                ->foreign('required_operation_id')
                ->references('id')
                ->on('required_operations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_required_operations');
    }
};
