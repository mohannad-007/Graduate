<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patient', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('birthday')->nullable();
            $table->string('image')->nullable();
//            $table->enum('address', [
//                'Damascus',
//                'Aleppo',
//                'Homs',
//                'Lattakia',
//                'Deir_ez_Zor',
//                'Tartous',
//                'Hama',
//                'Idlib',
//                'Rif_Dalah',
//                'As_Suwayda',
//                'Kalba',
//                'Dara',
//                'Dayr_Az_Zawr',
//                'Al_Hasakah',
//                'Al_Qamishly']);
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient');
//        Schema::dropIfExists('password_reset_tokens');
        //        Schema::dropIfExists('sessions');
    }
};
