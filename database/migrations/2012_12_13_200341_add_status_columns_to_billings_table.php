<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->string('status')->default('unpaid')->after('package_price');
            $table->unsignedInteger('paid_amount')->default(0)->after('status');
            $table->unsignedInteger('due_amount')->default(0)->after('paid_amount');
        });
    }

    public function down(): void
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->dropColumn(['status', 'paid_amount', 'due_amount']);
        });
    }
};