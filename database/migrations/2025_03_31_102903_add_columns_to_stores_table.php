<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('abbreviation')->nullable()->after('status');
            $table->string('name_kh')->nullable()->after('abbreviation');
            $table->string('name_en')->nullable()->after('name_kh');
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['abbreviation', 'name_kh', 'name_en']);
        });
    }
};
