<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveStoreCodeAndIsSubFromAbbreviationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abbreviations', function (Blueprint $table) {
            $table->dropColumn(['store_code', 'is_sub']);
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abbreviations', function (Blueprint $table) {
            $table->string('store_code')->nullable(); // adjust type if needed
            $table->boolean('is_sub')->default(false);
        });
    }
    
}
