<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->integer('contactType'); // 1:Customer 2:Supplier
            $table->string('contactCode');
            $table->string('contactFirstName');
            $table->string('contactLastName')->nullable();
            $table->string('contactEmail')->nullable();
            $table->string('contactPhone');
            $table->text('contactAddress');
            $table->string('contactCountry');
            $table->string('contactCity');
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
        Schema::dropIfExists('contacts');
    }
}
