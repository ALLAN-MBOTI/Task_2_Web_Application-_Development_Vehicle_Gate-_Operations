<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the user_login_logs table to store authentication timestamps and session IP context.
     */
    public function up(): void
    {
        Schema::create('user_login_logs', function (Blueprint $table) {
            $table->id();
            
            /* Foreign key pointing to the authenticated user */
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            /* Timestamp captured at the exact moment of successful authentication */
            $table->timestamp('login_at');
            
            /* Client IP address for auditing security sessions */
            $table->string('ip_address')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_login_logs');
    }
};