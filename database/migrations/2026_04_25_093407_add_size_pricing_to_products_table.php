<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('has_size')->default(false)->after('description');
            $table->decimal('price_s', 12, 2)->nullable()->after('has_size');
            $table->decimal('price_m', 12, 2)->nullable()->after('price_s');
            $table->decimal('price_l', 12, 2)->nullable()->after('price_m');
            $table->decimal('price_xl', 12, 2)->nullable()->after('price_l');
        });
    }

    public function down(): void
    {
        //
    }
};