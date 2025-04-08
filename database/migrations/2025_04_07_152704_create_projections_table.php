<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectionsTable extends Migration
{
    public function up()
    {
        Schema::create('projection', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('users');
            $table->date('projection_date'); 
            $table->decimal('estimated_income', 15, 2)->nullable();
            $table->foreignId('projected_by')->constrained('users'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projections');
    }
}
