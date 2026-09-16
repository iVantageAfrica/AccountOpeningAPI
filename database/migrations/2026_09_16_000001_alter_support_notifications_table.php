<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('support_notifications', function (Blueprint $table) {
            $table->string('firstname')->default('')->after('id');
            $table->string('lastname')->default('')->after('firstname');
            $table->string('status')->default('Active')->after('lastname');
        });

        DB::table('support_notifications')->update([
            'firstname' => 'Customer',
            'lastname' => 'Support Officer',
            'status' => 'Active',
        ]);

        Schema::table('support_notifications', function (Blueprint $table) {
            $table->dropColumn(['name', 'active']);
        });
    }

    public function down(): void
    {
        Schema::table('support_notifications', function (Blueprint $table) {
            $table->string('name')->default('')->after('id');
            $table->boolean('active')->default(true)->after('email');
        });

        DB::table('support_notifications')->each(function ($row) {
            DB::table('support_notifications')
                ->where('id', $row->id)
                ->update([
                    'name' => trim($row->firstname.' '.$row->lastname),
                    'active' => $row->status === 'Active',
                ]);
        });

        Schema::table('support_notifications', function (Blueprint $table) {
            $table->dropColumn(['firstname', 'lastname', 'status']);
        });
    }
};
