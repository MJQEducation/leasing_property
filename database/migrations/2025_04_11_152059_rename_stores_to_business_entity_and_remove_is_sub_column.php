<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::rename('stores', 'business_entity');

        Schema::table('business_entity', function (Blueprint $table) {
            $table->dropColumn('is_sub');
        });
    }

    public function down(): void
    {
        Schema::rename('business_entity', 'stores');

        Schema::table('stores', function (Blueprint $table) {
            $table->boolean('is_sub')->default(false);
        });
    }
};
