<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExitClearancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exit_clearances', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id')->nullable(); //Resign Employee ID
            $table->caseInsensitiveText('card_id', 20)->unique();
            $table->caseInsensitiveText('name', 100)->require();
            $table->caseInsensitiveText('position', 100)->require();
            $table->caseInsensitiveText('department', 100)->require();
            $table->caseInsensitiveText('line_management', 100)->require();
            $table->caseInsensitiveText('email', 100)->nullable();
            $table->caseInsensitiveText('phone', 100)->nullable();
            $table->dateTime('hired_date')->require();
            $table->dateTime('last_working_date')->require();
            $table->boolean('is_checked_completed')->default(false); //when check list completed
            $table->boolean('is_completed')->default(false); //when check list and signature completed
            $table->dateTime('completed_date')->nullable();
            $table->boolean('is_rejected')->default(false);
            $table->integer('rejected_id')->unsigned()->nullable();
            $table->caseInsensitiveText('rejected_code', 20)->nullable();
            $table->caseInsensitiveText('rejected_name', 100)->nullable();
            $table->caseInsensitiveText('rejected_position', 100)->nullable();
            $table->caseInsensitiveText('remark', 1000)->nullable();
            $table->integer('delby')->unsigned()->nullable();
            $table->integer('maker')->unsigned()->nullable();
            $table->string('status', 15);
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
        Schema::dropIfExists('exit_clearances');
    }
}
