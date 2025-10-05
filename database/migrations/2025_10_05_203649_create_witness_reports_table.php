<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('witness_reports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('query');
            $table->string('phone_e164')->nullable();
            $table->boolean('phone_valid')->default(false);
            $table->string('client_country', 2)->nullable();
            $table->string('ip')->nullable();
            $table->string('fbi_uid')->nullable();
            $table->string('fbi_title')->nullable();
            $table->string('fbi_url')->nullable();
            $table->string('validity')->default('unknown');
            $table->index(['client_country', 'validity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('witness_reports');
    }
};
