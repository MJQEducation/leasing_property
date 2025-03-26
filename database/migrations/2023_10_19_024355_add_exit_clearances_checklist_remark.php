<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExitClearancesChecklistRemark extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exit_clearance_check_lists', function (Blueprint $table) {
            $table->caseInsensitiveText('remarks')->nullable()->after('ordinal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exit_clearance_check_lists', function (Blueprint $table) {
            $table->dropColumn('remarks');
        });
    }
}
