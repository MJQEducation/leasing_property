<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mainvaluelists', function (Blueprint $table) {
            $table->string('code', 255)->nullable()->after('value'); // Add 'code' column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mainvaluelists', function (Blueprint $table) {
            $table->dropColumn('code'); // Remove 'code' column if rolled back
        });
    }
};
