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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('bvn');
            $table->string('nin')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->boolean('status')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');

    }
};
