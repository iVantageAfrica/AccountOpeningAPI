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
        Schema::create('merchant_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('account_type_id')->constrained('account_types');
            $table->string('account_number')->nullable();
            $table->string('business_sector')->nullable();
            $table->string('business_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('business_address')->nullable();
            $table->string('email_address')->nullable();
            $table->string('lga')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('cac', 1000)->nullable();
            $table->foreignId('document_id')->nullable()->constrained('documents');
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
        Schema::dropIfExists('merchant_account');
    }
};
