<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('vehicle_make')->nullable()->after('oem_number');
            $table->string('vehicle_model')->nullable()->after('vehicle_make');
            $table->string('part_brand')->nullable()->after('vehicle_model');
            $table->enum('condition', ['Sıfır', 'İkinci El'])->default('Sıfır')->after('part_brand');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['vehicle_make', 'vehicle_model', 'part_brand', 'condition']);
        });
    }
};
