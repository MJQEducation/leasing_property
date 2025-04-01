<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leasing_id'); 
            $table->date('payment_date');
            $table->decimal('penalty_amount', 10, 2);
            $table->decimal('final_charge', 10, 2);
            $table->decimal('amount_paid', 10, 2);
            $table->timestamps();

            // Adding foreign key constraints
            $table->foreign('leasing_id')->references('id')->on('leasings')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
}
