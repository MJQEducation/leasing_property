<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubstoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('substore', function (Blueprint $table) {
            $table->id();
            $table->string('substore_code');
            $table->string('store_code'); 
            $table->string('abbreviation');
            $table->string('name_kh');
            $table->string('name_en');
            $table->string('campus');
            $table->text('location');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('store_code')->references('store_code')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('substore');
    }
}
