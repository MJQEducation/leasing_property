<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyPricesTable extends Migration
{
    public function up()
    {
        Schema::create('rental_price', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID
            $table->decimal('price', 10, 2);  // Price (decimal type for currency)
            $table->timestamp('from');  // Start date for the price
            $table->timestamp('to');  // End date for the price
            $table->foreignId('property_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Foreign key referencing 'users' table
            $table->timestamp('deleted_at')->nullable();  // Soft delete column
            $table->timestamps();  // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('property_prices');
    }
}
