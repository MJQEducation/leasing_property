<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExitClearanceSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exit_clearance_signatures', function (Blueprint $table) {
            $table->id();
            $table->integer('exit_id')->unsigned()->require();
            $table->caseInsensitiveText('sign_title', 20);
            $table->integer('signed_id')->unsigned();
            $table->caseInsensitiveText('signed_code', 20);
            $table->caseInsensitiveText('emp_name', 100);
            $table->caseInsensitiveText('position', 100);
            $table->boolean('is_signed')->default(false);
            $table->integer('ordinal')->unsigned();
            $table->dateTime('signed_date')->nullable();
            $table->integer('delby')->unsigned()->nullable();
            $table->integer('maker')->unsigned()->nullable();
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
        Schema::dropIfExists('exit_clearance_signatures');
    }
}
