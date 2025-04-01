<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leasings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id');
            $table->string('store_code', 275);  // Set store_code to varchar(275)
            $table->decimal('owed_amount', 10, 2);
            $table->decimal('discount_request', 10, 2);
            $table->decimal('owner_offer', 10, 2);
            $table->decimal('final_charge', 10, 2);
            $table->date('alert_date');
            $table->timestamps();

            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
            $table->foreign('store_code')->references('store_code')->on('stores')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leasings');
    }
};
