<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_po')->default(false)->after('has_size');
            $table->integer('po_days')->nullable()->after('is_po');
        });
    }

public function down(): void {}

   
};
