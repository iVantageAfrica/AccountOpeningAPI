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
        Schema::create('individual_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('account_type_id')->constrained('account_types');
            $table->string('account_number')->nullable();
            $table->string('mother_maiden_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('house_number')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_address')->nullable();
            $table->string('next_of_kin_relationship')->nullable();
            $table->string('next_of_kin_phone_number')->nullable();
            $table->foreignId('document_id')->nullable()->constrained('documents');
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
        Schema::dropIfExists('individual_accounts');
    }
};
