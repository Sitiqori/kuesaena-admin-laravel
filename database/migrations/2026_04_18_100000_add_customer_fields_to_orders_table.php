<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('delivery_method')->default('pickup')->after('payment_method'); // pickup / delivery
            $table->string('size')->nullable()->after('delivery_method');
            $table->string('cake_flavor')->nullable()->after('size');
            $table->text('notes')->nullable()->after('cake_flavor');
            $table->dateTime('scheduled_at')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['delivery_method', 'size', 'cake_flavor', 'notes', 'scheduled_at']);
        });
    }
};
