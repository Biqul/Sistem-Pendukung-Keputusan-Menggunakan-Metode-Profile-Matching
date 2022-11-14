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
        Schema::create('pembukaan_seleksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id');
            $table->boolean('done')->default(false);
            $table->string('name',115);
            $table->integer('kuota')->nullable();
            $table->float('nilai_ambang')->nullable();
            $table->string('slug', 115)->unique();
            $table->string('periode',20);
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
        Schema::dropIfExists('pembukaan_seleksis');
    }
};
