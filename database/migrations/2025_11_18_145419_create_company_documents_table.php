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
        Schema::create('company_documents', function (Blueprint $table) {
            $table->id();
            $table->longText('cac')->nullable();
            $table->longText('memart')->nullable();
            $table->longText('cac_co2')->nullable();
            $table->longText('cac_co7')->nullable();
            $table->longText('board_resolution')->nullable();
            $table->longText('partnership_resolution')->nullable();
            $table->longText('declaration_form')->nullable();
            $table->longText('proprietor_declaration')->nullable();
            $table->longText('signatory_mandate')->nullable();
            $table->longText('partnership_deed')->nullable();
            $table->longText('tin')->nullable();
            $table->longText('society_resolution')->nullable();
            $table->longText('principal_list')->nullable();
            $table->longText('constitution')->nullable();
            $table->longText('trustee_list')->nullable();
            $table->longText('trust_deed')->nullable();
            $table->longText('trustee_resolution')->nullable();
            $table->longText('nipc_certificate')->nullable();
            $table->longText('business_permit')->nullable();
            $table->longText('due_diligence')->nullable();
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
        Schema::dropIfExists('company_documents');
    }
};
