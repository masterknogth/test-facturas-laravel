<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
       
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number');
            $table->string('seller_name');
            $table->integer('seller_nit');
            $table->string('buyer_name');
            $table->integer('buyer_nit');
            $table->string('date');
            $table->string('hour');
           /* $table->float('value');
            $table->float('total_value');*/
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
        Schema::dropIfExists('invoices');
    }
}
