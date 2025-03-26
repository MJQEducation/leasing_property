<?php

use Illuminate\Database\Migrations\Migration;
use Tpetry\PostgresqlEnhanced\Schema\Blueprint;
use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('card_id')->unique()->nullable();
            $table->caseInsensitiveText('name', 60);
            $table->string('username', 100)->unique();
            $table->caseInsensitiveText('position', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('google_id', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 100);
            $table->integer('maker')->unsigned()->nullable();
            $table->integer('delby')->unsigned()->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
