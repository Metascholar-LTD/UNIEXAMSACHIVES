<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change enum to VARCHAR to allow new statuses like 'partial'
        DB::statement("ALTER TABLE comm_campaigns MODIFY COLUMN status VARCHAR(20) NOT NULL DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum (note: will fail if unknown values exist)
        DB::statement("ALTER TABLE comm_campaigns MODIFY COLUMN status ENUM('draft', 'scheduled', 'sending', 'sent', 'failed') NOT NULL DEFAULT 'draft'");
    }
};


