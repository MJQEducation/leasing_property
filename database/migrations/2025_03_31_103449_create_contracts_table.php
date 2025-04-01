<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('store_code'); 
            $table->unsignedBigInteger('customer_id');
            $table->decimal('deposit_amount', 10, 2);
            $table->decimal('management_fee', 10, 2);
            $table->decimal('water_fee', 10, 2);
            $table->decimal('penalty_payment', 10, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('remaining_days');
            $table->string('contract_type');
            $table->boolean('status')->default(1);
            $table->decimal('monthly_fee', 10, 2);
            $table->decimal('year_fee', 10, 2);
            $table->string('contact_person');
            $table->timestamps();
    
            $table->foreign('store_code')->references('store_code')->on('stores')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
