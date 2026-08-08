<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for vehicles, drivers, and gate operations.
     */
    public function up(): void
    {
        // 1. Create Vehicles Table
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->string('vehicle_type');
            $table->timestamps();
        });

        // 2. Create Drivers Table
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('driver_id')->unique();
            $table->string('phone_number');
            $table->timestamps();
        });

        // 3. Create Gate Records Table
        Schema::create('gate_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['GATED_IN', 'GATED_OUT'])->default('GATED_IN');
            $table->timestamp('date_time_in');
            $table->timestamp('date_time_out')->nullable();
            $table->foreignId('gated_in_by_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('gated_out_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gate_records');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('vehicles');
    }
};