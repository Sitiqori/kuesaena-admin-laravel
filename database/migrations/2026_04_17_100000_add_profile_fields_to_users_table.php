<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->after('name');
            $table->string('phone')->nullable()->after('email');
            $table->date('birth_date')->nullable()->after('phone');
            $table->enum('gender', ['male', 'female'])->nullable()->after('birth_date');
            $table->string('photo')->nullable()->after('gender');
            $table->boolean('notif_whatsapp')->default(true)->after('photo');
            $table->boolean('notif_pesanan')->default(true)->after('notif_whatsapp');
            $table->boolean('notif_promo')->default(true)->after('notif_pesanan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username','phone','birth_date','gender','photo',
                'notif_whatsapp','notif_pesanan','notif_promo'
            ]);
        });
    }
};