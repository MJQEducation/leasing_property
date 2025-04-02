<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['store_code']); // Drop the existing foreign key
            $table->boolean('is_substore')->default(false)->after('store_code'); // Add new column
            
            // Modify foreign key constraint logic
            $table->foreign('store_code')->references('store_code')->on('stores')->onDelete('cascade');
            $table->foreign('store_code')->references('substore_code')->on('substores')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['store_code']); // Drop new constraints
            $table->dropColumn('is_substore'); // Remove the new column

            // Restore original foreign key constraint
            $table->foreign('store_code')->references('store_code')->on('stores')->onDelete('cascade');
        });
    }
};
