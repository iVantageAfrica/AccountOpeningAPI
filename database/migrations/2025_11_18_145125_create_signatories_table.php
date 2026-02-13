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
        Schema::create('signatories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('bvn')->nullable();
            $table->string('nin')->nullable();
            $table->longText('signature')->nullable();
            $table->longText('passport')->nullable();
            $table->longText('proof_of_address')->nullable();
            $table->longText('specimen_signature')->nullable();
            $table->longText('partnership_deed')->nullable();
            $table->longText('mode_of_operation')->nullable();
            $table->longText('joint_mandate')->nullable();
            $table->longText('board_approve')->nullable();
            $table->boolean('is_submitted')->default(false);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_signatories');
    }
};
