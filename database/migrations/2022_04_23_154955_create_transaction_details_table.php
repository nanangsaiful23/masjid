<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transaction_id')
                  ->unsigned()
                  ->nullable();
            $table->bigInteger('muzakki_id')
                  ->unsigned()
                  ->nullable();
            $table->bigInteger('zakat_id')
                  ->unsigned()
                  ->nullable();
            $table->string("nominal")
                  ->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('transaction_id')
                  ->references('id')
                  ->on('transactions')
                  ->onDelete('cascade');

            $table->foreign('muzakki_id')
                  ->references('id')
                  ->on('muzakkis')
                  ->onDelete('cascade');

            $table->foreign('zakat_id')
                  ->references('id')
                  ->on('zakats')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
}
