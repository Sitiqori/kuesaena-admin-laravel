<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=off;');
            DB::statement('ALTER TABLE users RENAME TO users_old;');

            DB::statement('CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name VARCHAR NOT NULL,
                email VARCHAR NOT NULL UNIQUE,
                email_verified_at DATETIME,
                password VARCHAR NOT NULL,
                role VARCHAR(20) NOT NULL DEFAULT "pelanggan",
                is_active TINYINT(1) DEFAULT 1,
                office VARCHAR,
                remember_token VARCHAR,
                created_at DATETIME,
                updated_at DATETIME
            );');

            DB::statement('INSERT INTO users SELECT
                id, name, email, email_verified_at, password,
                COALESCE(role, "pelanggan"),
                is_active, office, remember_token, created_at, updated_at
            FROM users_old;');

            DB::statement('DROP TABLE users_old;');
            DB::statement('PRAGMA foreign_keys=on;');
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 20)->default('pelanggan')->change();
            });
        }
    }

    public function down(): void
    {
        // optional: bisa ditambah rollback kalau mau
    }
};
