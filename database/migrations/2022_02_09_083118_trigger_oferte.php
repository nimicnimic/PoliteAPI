<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class TriggerOferte extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Oferte', function (Blueprint $table) {            
            DB::unprepared('CREATE TRIGGER `nr_oferta` BEFORE INSERT ON `Oferte` FOR EACH ROW
                            SET new.Numar = (SELECT (IF (Numar IS NULL, 0, MAX(Numar)) + 1) AS Nr FROM Oferte t WHERE t.Serie = new.Serie);');            

            // musai de pus alias la SELECT pt ca altfel da eroare ca nu are GROUP BY
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Oferte', function (Blueprint $table) {
            //
        });
    }
}
