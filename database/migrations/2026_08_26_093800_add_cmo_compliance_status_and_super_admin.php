<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('individual_accounts', function (Blueprint $table) {
            $table->string('cmo_status')->nullable()->after('status');
            $table->foreignId('cmo_reviewed_by')->nullable()->after('cmo_status')->constrained('admins')->nullOnDelete();
            $table->timestamp('cmo_reviewed_at')->nullable()->after('cmo_reviewed_by');
            $table->text('cmo_flagged_reason')->nullable()->after('cmo_reviewed_at');
            $table->string('compliance_status')->nullable()->after('cmo_flagged_reason');
            $table->foreignId('compliance_reviewed_by')->nullable()->after('compliance_status')->constrained('admins')->nullOnDelete();
            $table->timestamp('compliance_reviewed_at')->nullable()->after('compliance_reviewed_by');
            $table->text('compliance_flagged_reason')->nullable()->after('compliance_reviewed_at');
        });

        Schema::table('corporate_accounts', function (Blueprint $table) {
            $table->string('cmo_status')->nullable()->after('status');
            $table->foreignId('cmo_reviewed_by')->nullable()->after('cmo_status')->constrained('admins')->nullOnDelete();
            $table->timestamp('cmo_reviewed_at')->nullable()->after('cmo_reviewed_by');
            $table->text('cmo_flagged_reason')->nullable()->after('cmo_reviewed_at');
            $table->string('compliance_status')->nullable()->after('cmo_flagged_reason');
            $table->foreignId('compliance_reviewed_by')->nullable()->after('compliance_status')->constrained('admins')->nullOnDelete();
            $table->timestamp('compliance_reviewed_at')->nullable()->after('compliance_reviewed_by');
            $table->text('compliance_flagged_reason')->nullable()->after('compliance_reviewed_at');
        });

        DB::table('admins')->insert([
            'firstname' => 'Imperial',
            'lastname' => 'Super Admin',
            'email' => 'superadmin@imperial.com',
            'password' => Hash::make('Super@333'),
            'is_admin' => true,
            'is_super_admin' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::table('individual_accounts', function (Blueprint $table) {
            $table->dropForeign(['cmo_reviewed_by']);
            $table->dropForeign(['compliance_reviewed_by']);
            $table->dropColumn([
                'cmo_status', 'cmo_reviewed_by', 'cmo_reviewed_at', 'cmo_flagged_reason',
                'compliance_status', 'compliance_reviewed_by', 'compliance_reviewed_at', 'compliance_flagged_reason',
            ]);
        });

        Schema::table('corporate_accounts', function (Blueprint $table) {
            $table->dropForeign(['cmo_reviewed_by']);
            $table->dropForeign(['compliance_reviewed_by']);
            $table->dropColumn([
                'cmo_status', 'cmo_reviewed_by', 'cmo_reviewed_at', 'cmo_flagged_reason',
                'compliance_status', 'compliance_reviewed_by', 'compliance_reviewed_at', 'compliance_flagged_reason',
            ]);
        });

        DB::table('admins')->where('email', 'superadmin@imperial.com')->delete();
    }
};
