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
        // Create the 'details' table
        Schema::create('details', function (Blueprint $table) {
            $table->id();

            // Link to users table
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Link to customers table (nullable)
            $table->foreignId('customer_id')
                  ->nullable()
                  ->constrained('customers')
                  ->cascadeOnDelete();

            // Fields used in UserController@store
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('dob')->nullable();
            $table->string('pin')->nullable();
            $table->string('router_password')->nullable();
            $table->string('package_name')->nullable();
            $table->string('router_name')->nullable();
            $table->decimal('package_price', 10, 2)->default(0);
            $table->decimal('due', 10, 2)->default(0);
            $table->enum('status', ['active','inactive','suspended'])->default('active');
            $table->timestamp('package_start')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('customer_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details');
    }
};
