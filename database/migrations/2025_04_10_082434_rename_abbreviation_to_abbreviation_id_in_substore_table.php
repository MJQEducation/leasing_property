<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAbbreviationToAbbreviationIdInSubstoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('substore', function (Blueprint $table) {
            $table->renameColumn('abbreviation', 'abbreviation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('substore', function (Blueprint $table) {
            $table->renameColumn('abbreviation_id', 'abbreviation');
        });
    }
}
