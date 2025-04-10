<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStoresTableToAddAbbreviationId extends Migration
{
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            // Drop the old abbreviation column if it exists
            $table->dropColumn('abbreviation');

            // Add new abbreviation_id column as foreign key
            $table->unsignedBigInteger('abbreviation_id')->nullable();

            // Add foreign key constraint to abbreviation_id
            $table->foreign('abbreviation_id')->references('id')->on('abbreviations')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            // Rollback the changes: drop abbreviation_id and restore the abbreviation column
            $table->dropForeign(['abbreviation_id']);
            $table->dropColumn('abbreviation_id');

            // If necessary, add the old abbreviation column back
            $table->string('abbreviation')->nullable();
        });
    }
}
