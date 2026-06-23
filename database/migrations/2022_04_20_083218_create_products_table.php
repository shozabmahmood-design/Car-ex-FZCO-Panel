
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); 
            $table->integer('user_id');
            $table->integer('brand_id');
            $table->integer('type_id');
            $table->string('title');
            $table->string('image');
            $table->text('model');
            $table->text('man_year');
            $table->text('description');
            $table->string('color');
            $table->text('drive_type');
            $table->string('transmission');
            $table->string('fuel_type');
            $table->text('engine_size');
            $table->text('doors');
            $table->text('cylenders');
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
        Schema::dropIfExists('products');
    }
}








