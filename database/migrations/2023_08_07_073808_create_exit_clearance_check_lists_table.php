<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExitClearanceCheckListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exit_clearance_check_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('bulletin_id')->unsigned()->require(); //exit_clearance_bulletins id
            $table->integer('questionnaire')->unsigned()->require(); //mvl
            $table->integer('checked_id')->unsigned();
            $table->caseInsensitiveText('checked_code', 20);
            $table->caseInsensitiveText('emp_name', 100);
            $table->caseInsensitiveText('position', 100);
            $table->string('is_checked', 20)->default('Unchecked'); //Unchecked,Checked,Unavailable,
            $table->dateTime('checked_date')->nullable();
            $table->integer('ordinal')->unsigned();
            $table->integer('maker')->unsigned()->nullable();
            $table->integer('delby')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exit_clearance_check_lists');
    }
}
