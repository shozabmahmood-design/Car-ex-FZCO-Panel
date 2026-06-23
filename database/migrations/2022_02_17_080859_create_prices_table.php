<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->string('perMile');
            $table->string('perStairs');
            $table->string('congestionZone');
            $table->string('ulezZone');
            $table->string('noHelper');
            $table->string('driverHelping');
            $table->string('driver1Helper');
            $table->string('driver2Helper');
            $table->string('smlVan');
            $table->string('mdVan');
            $table->string('lgVan');
            $table->string('xlVan');
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
        Schema::dropIfExists('prices');
    }
}
