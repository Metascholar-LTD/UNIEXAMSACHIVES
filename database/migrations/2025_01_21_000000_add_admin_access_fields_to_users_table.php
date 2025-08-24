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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('admin_access_requested')->default(false)->after('password_changed');
            $table->text('admin_access_reason')->nullable()->after('admin_access_requested');
            $table->string('admin_access_supervisor')->nullable()->after('admin_access_reason');
            $table->string('admin_access_supervisor_email')->nullable()->after('admin_access_supervisor');
            $table->timestamp('admin_access_requested_at')->nullable()->after('admin_access_supervisor_email');
            $table->timestamp('admin_access_approved_at')->nullable()->after('admin_access_requested_at');
            $table->unsignedBigInteger('admin_access_approved_by')->nullable()->after('admin_access_approved_at');
            $table->timestamp('admin_access_rejected_at')->nullable()->after('admin_access_approved_by');
            $table->unsignedBigInteger('admin_access_rejected_by')->nullable()->after('admin_access_rejected_at');
            $table->text('admin_access_rejected_reason')->nullable()->after('admin_access_rejected_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'admin_access_requested',
                'admin_access_reason',
                'admin_access_supervisor',
                'admin_access_supervisor_email',
                'admin_access_requested_at',
                'admin_access_approved_at',
                'admin_access_approved_by',
                'admin_access_rejected_at',
                'admin_access_rejected_by',
                'admin_access_rejected_reason'
            ]);
        });
    }
};
