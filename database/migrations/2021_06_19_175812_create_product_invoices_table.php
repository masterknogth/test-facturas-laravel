<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("invoice_id")->unsigned()->index();   
            $table->string('description');
            $table->integer('quantity');
            $table->float('value');
            $table->float('total_value');
            
            $table->timestamps();

            $table->foreign('invoice_id')
            ->references('id')
            ->on('invoices')
            ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_invoices');
    }
}
