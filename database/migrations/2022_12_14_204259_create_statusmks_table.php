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
        Schema::create('statusmks', function (Blueprint $table) {
            $table->id('idstatus');
            $table->string('status');
            $table->timestamps();
            $table->unsignedBigInteger('fkUser');
            $table->foreign('fkUser')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('fkMata');
            $table->foreign('fkMata')->references('idMata')->on('matakuliahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statusmks');
    }
};
