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
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspek_id');
            $table->foreignId('status_id');
            $table->foreignId('type_id');
            $table->string('kode_kriteria', 20)->unique();
            $table->string('name', 115);
            $table->string('slug', 115)->unique();
            $table->integer('value');
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
        Schema::dropIfExists('kriterias');
    }
};
