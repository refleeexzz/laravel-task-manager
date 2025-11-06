<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // add qa_review to status enum
        \DB::statement("ALTER TABLE tasks DROP CONSTRAINT IF EXISTS tasks_status_check");
        \DB::statement("ALTER TABLE tasks ADD CONSTRAINT tasks_status_check CHECK (status IN ('pending', 'in_progress', 'completed', 'qa_review'))");
    }

    public function down(): void
    {
        \DB::statement("ALTER TABLE tasks DROP CONSTRAINT IF EXISTS tasks_status_check");
        \DB::statement("ALTER TABLE tasks ADD CONSTRAINT tasks_status_check CHECK (status IN ('pending', 'in_progress', 'completed'))");
    }
};
