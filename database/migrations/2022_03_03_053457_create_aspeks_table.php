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
        Schema::create('aspeks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 115);
            $table->string('slug', 115)->unique();
            $table->foreignId('status_id');
            $table->integer('persentase');
            $table->integer('core');
            $table->integer('secondary');
            $table->integer('core_count')->nullable();
            $table->integer('secondary_count')->nullable();
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
        Schema::dropIfExists('aspeks');
    }
};
