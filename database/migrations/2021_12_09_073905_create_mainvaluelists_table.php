<?php

use Illuminate\Database\Migrations\Migration;
use Tpetry\PostgresqlEnhanced\Schema\Blueprint;
use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;

class CreateMainvaluelistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mainvaluelists', function (Blueprint $table) {
            $table->id();
            $table->caseInsensitiveText('abbreviation', 50)->nullable();
            $table->caseInsensitiveText('name_en', 100);
            $table->caseInsensitiveText('name_kh', 100);
            $table->caseInsensitiveText('type', 50);
            $table->string('value', 100);
            $table->integer('ordinal')->unsigned()->nullable();
            $table->integer('parent_mvl')->unsigned()->nullable();
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
        Schema::dropIfExists('mainvaluelists');
    }
}
