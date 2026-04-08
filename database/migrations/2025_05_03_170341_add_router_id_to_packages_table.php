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
        if (!Schema::hasColumn('packages', 'router_id')) {
            Schema::table('packages', function (Blueprint $table) {
                $table->foreignId('router_id')->constrained()->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('packages', 'router_id')) {
            Schema::table('packages', function (Blueprint $table) {
                // First drop foreign key constraint
                $table->dropForeign(['router_id']);
                // Then drop the column
                $table->dropColumn('router_id');
            });
        }
    }
};
