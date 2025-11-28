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
        Schema::create('lotteryResult', function (Blueprint $table) {
            $table->id();
            $table->integer('lotteryResult')->index();
            $table->string('open_date',20);
            $table->string('result',20);
            $table->integer('r1');
            $table->integer('r2');
            $table->integer('r3');
            $table->integer('r4');
            $table->integer('r5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotteryResult');
    }
};
