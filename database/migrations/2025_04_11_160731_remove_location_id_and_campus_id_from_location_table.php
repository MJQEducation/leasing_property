<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('business_entity', function (Blueprint $table) {
            $table->dropColumn(['location_id', 'campus_id']);
        });
    }

    public function down(): void
    {
        Schema::table('business_entity', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('campus_id')->nullable();
        });
    }
};
