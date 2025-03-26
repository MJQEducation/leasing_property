<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExitClearanceBulletinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exit_clearance_bulletins', function (Blueprint $table) {
            $table->id();
            $table->integer('exit_id')->unsigned()->require(); //exit_clearances id
            $table->integer('questionnaire')->unsigned()->require(); //mvl
            $table->integer('checked_id')->unsigned(); //First Initial to all Check List
            $table->caseInsensitiveText('checked_code', 20); //First Initial to all Check List
            $table->caseInsensitiveText('emp_name', 100); //First Initial to all Check List
            $table->caseInsensitiveText('position', 100); //First Initial to all Check List
            $table->integer('ordinal')->unsigned(); //First Initial to all Check List
            $table->boolean('is_completed')->default(false);
            $table->dateTime('completed_date')->nullable();
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
        Schema::dropIfExists('exit_clearance_bulletins');
    }
}
