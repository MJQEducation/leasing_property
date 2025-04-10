<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInSubstoreTable extends Migration
{
    public function up()
    {
        Schema::table('substore', function (Blueprint $table) {
            // Drop the existing columns (if any)
            $table->dropColumn('location');
            $table->dropColumn('campus');

            // Add new columns as foreign keys
            $table->unsignedBigInteger('location_id')->nullable()->after('column_name'); 
            $table->unsignedBigInteger('campus_id')->nullable()->after('location_id');
            
            // Add foreign key constraints
            $table->foreign('location_id')->references('id')->on('location')->onDelete('set null');
            $table->foreign('campus_id')->references('id')->on('campus')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('substore', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropForeign(['campus_id']);
            $table->dropColumn('location_id');
            $table->dropColumn('campus_id');
            
            // Re-add original columns (if needed)
            $table->string('location')->nullable();
            $table->string('campus')->nullable();
        });
    }
}
