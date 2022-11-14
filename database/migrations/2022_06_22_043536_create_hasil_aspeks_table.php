<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_aspeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembukaan_id');
            $table->foreignId('alternatif_id');
            $table->foreignId('aspek_id');
            $table->float('ncf');
            $table->float('nsf');
            $table->float('total');
            $table->float('totalEach');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasil_aspeks');
    }
};
