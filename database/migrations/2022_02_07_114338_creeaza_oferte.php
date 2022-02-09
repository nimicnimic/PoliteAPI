<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreeazaOferte extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Oferte', function (Blueprint $table) {
            $table->bigIncrements('IdOferta');
            $table->string('Serie', 5);
            $table->string('Numar', 15);
            $table->date('DataEmitere');
            $table->date('DataStart');
            $table->date('DataEnd');
            $table->double('Prima', 10, 2);
            $table->double('SumaAsigurata', 15, 2);
            $table->enum('Valuta', ['RON', 'EUR', 'USD']);
            $table->tinyInteger('PachetAsigurare');
            $table->string('Optional')->nullable();
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
        Schema::dropIfExists('Oferte');
    }
}
