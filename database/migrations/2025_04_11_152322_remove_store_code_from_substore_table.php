<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('substore', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['store_code']);
            // Then drop the column
            $table->dropColumn('store_code');
        });
    }

    public function down(): void
    {
        Schema::table('substore', function (Blueprint $table) {
            $table->string('store_code');

            $table->foreign('store_code')->references('store_code')->on('stores')->onDelete('cascade');
        });
    }
};
