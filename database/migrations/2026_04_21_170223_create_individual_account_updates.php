<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('individual_account_updates', static function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->index();
            $table->string('mother_maiden_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email_address')->nullable();
            $table->string('employment_status');
            $table->string('employer')->nullable();
            $table->string('account_officer')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('house_number')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('origin')->nullable();
            $table->string('lga')->nullable();
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_address')->nullable();
            $table->string('next_of_kin_phone_number')->nullable();
            $table->string('next_of_kin_relationship')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individual_account_updates');
    }
};
