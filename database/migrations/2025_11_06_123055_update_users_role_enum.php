<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // add qa role to enum
        \DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
        \DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'editor', 'reader', 'qa'))");
    }

    public function down(): void
    {
        \DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
        \DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'editor', 'reader'))");
    }
};
