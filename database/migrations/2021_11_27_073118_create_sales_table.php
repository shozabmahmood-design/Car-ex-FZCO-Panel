<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('saleId');
            $table->string('date');
            $table->string('contact_id');
            $table->string('orderTax')->default(0);
            $table->string('discount')->default(0);
            $table->string('shipping')->default(0);
            $table->integer('totalItems');
            $table->integer('totalAmount');
            $table->integer('grandTotal');
            $table->integer('status'); // 0:Pending 1:Ordered 2:Completed
            $table->integer('payment'); // 0:Unpaid 1:Partial 2:Paid
            $table->string('paymentChoice')->nullable();
            $table->string('receivedAmount')->nullable();
            $table->string('payingAmount')->nullable();
            $table->string('changeAmount')->nullable();
            $table->string('creditCardNo')->nullable();
            $table->string('creditCardExp')->nullable();
            $table->string('creditCardCvc')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
