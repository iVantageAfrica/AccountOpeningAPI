<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('individual_accounts', function (Blueprint $table) {
            $table->foreignId('compliance_assigned_to')->nullable()->after('compliance_flagged_reason')->constrained('admins')->nullOnDelete();
            $table->timestamp('compliance_assigned_at')->nullable()->after('compliance_assigned_to');
        });

        Schema::table('corporate_accounts', function (Blueprint $table) {
            $table->foreignId('compliance_assigned_to')->nullable()->after('compliance_flagged_reason')->constrained('admins')->nullOnDelete();
            $table->timestamp('compliance_assigned_at')->nullable()->after('compliance_assigned_to');
        });
    }

    public function down(): void
    {
        Schema::table('individual_accounts', function (Blueprint $table) {
            $table->dropForeign(['compliance_assigned_to']);
            $table->dropColumn(['compliance_assigned_to', 'compliance_assigned_at']);
        });

        Schema::table('corporate_accounts', function (Blueprint $table) {
            $table->dropForeign(['compliance_assigned_to']);
            $table->dropColumn(['compliance_assigned_to', 'compliance_assigned_at']);
        });
    }
};