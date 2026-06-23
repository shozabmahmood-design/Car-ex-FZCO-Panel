<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('currency');
            $table->string('businessName');
            $table->text('businessLogo')->nullable();
            $table->string('businessEmail');
            $table->string('businessPhone');
            $table->string('businessAddress');
            $table->string('businessWebsite')->nullable();
            $table->text('footerText')->nullable();
            $table->text('receiptFooterText')->nullable();
            $table->integer('showPhone')->default(1);
            $table->integer('showAddress')->default(1);
            $table->integer('showEmail')->default(1);
            $table->integer('user_id');
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
        Schema::dropIfExists('settings');
    }
}
