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
        Schema::create('alternatifs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('seleksi_id')->nullable();
            $table->foreignId('status_id')->nullable();
            $table->integer('hasil_id')->nullable();
            $table->string('name',115);
            $table->string('no_hp',20)->unique();
            $table->string('email',115);
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
        Schema::dropIfExists('alternatifs');
    }
};
