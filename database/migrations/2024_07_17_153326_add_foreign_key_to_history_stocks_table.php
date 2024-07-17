<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_stocks', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('stock_price_id')->nullable(); // Make it nullable if necessary
            $table->foreign('stock_price_id')->references('id')->on('stock_prices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_stocks', function (Blueprint $table) {
            //
            $table->dropForeign(['stock_price_id']);
            $table->dropColumn('stock_price_id');
        });
    }
};
