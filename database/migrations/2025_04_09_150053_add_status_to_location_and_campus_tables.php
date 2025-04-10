<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToLocationAndCampusTables extends Migration
{
    public function up()
    {
        // Add status column to location table with default true
        Schema::table('location', function (Blueprint $table) {
            $table->boolean('status')->default(true)->after('name_kh'); // Adjust the column position as needed
        });

        // Add status column to campus table with default true
        Schema::table('campus', function (Blueprint $table) {
            $table->boolean('status')->default(true)->after('name_kh'); // Adjust the column position as needed
        });
    }

    public function down()
    {
        // Drop status column from location table
        Schema::table('location', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Drop status column from campus table
        Schema::table('campus', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
