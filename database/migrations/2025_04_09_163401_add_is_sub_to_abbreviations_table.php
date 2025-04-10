<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSubToAbbreviationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abbreviations', function (Blueprint $table) {
            // Add the is_sub column as a boolean with a default value of false
            $table->boolean('is_sub')->default(false);
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
            // Drop the is_sub column if the migration is rolled back
            $table->dropColumn('is_sub');
        });
    }
}
