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
        Schema::create('corporate_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('account_type_id')->constrained('account_types');
            $table->string('account_number')->nullable();
            $table->string('company_name')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('company_type')->nullable();
            $table->string('tin')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('business_email')->nullable();
            $table->string('city')->nullable();
            $table->string('lga')->nullable();
            $table->string('state')->nullable();
            $table->string('account_officer')->nullable();
            $table->string('cac', 1000)->nullable();
            $table->json('signatories')->nullable();
            $table->json('directors')->nullable();
            $table->json('referees')->nullable();
            $table->boolean('debit_card')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_accounts');
    }
};
