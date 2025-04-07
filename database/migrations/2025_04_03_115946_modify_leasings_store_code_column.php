<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('leasings', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['store_code']);

            // Modify store_code column to be a normal varchar(255)
            $table->string('store_code', 255)->change();
        });
    }

    public function down(): void
    {
        Schema::table('leasings', function (Blueprint $table) {
            // Revert store_code to its original state with a foreign key
            $table->string('store_code', 275)->change();
            $table->foreign('store_code')->references('store_code')->on('stores')->onDelete('cascade');
        });
    }
};
