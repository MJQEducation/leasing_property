<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToRentalPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rental_price', function (Blueprint $table) {
            $table->string('month_request')->nullable();
            $table->string('month_offer')->nullable();
            $table->decimal('descrease_amount', 10, 2)->nullable();
            $table->decimal('amount_charge', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rental_price', function (Blueprint $table) {
            $table->dropColumn(['month_request', 'month_offer', 'descrease_amount', 'amount_charge']);
        });
    }
}
