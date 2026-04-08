<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add missing columns to invoices table
        Schema::table('invoices', function (Blueprint $table) {
            // Only add if customer_id doesn't exist
            if (!Schema::hasColumn('invoices', 'customer_id')) {
                $table->foreignId('customer_id')->after('invoice_number')->constrained('customers')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('invoices', 'billing_id')) {
                $table->foreignId('billing_id')->nullable()->after('customer_id')->constrained('billings')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('invoices', 'payment_id')) {
                $table->foreignId('payment_id')->nullable()->after('billing_id')->constrained('payments')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('invoices', 'package_name')) {
                $table->string('package_name')->after('payment_id');
            }
            
            if (!Schema::hasColumn('invoices', 'amount')) {
                $table->unsignedInteger('amount')->after('package_name');
            }
            
            if (!Schema::hasColumn('invoices', 'paid_amount')) {
                $table->unsignedInteger('paid_amount')->default(0)->after('amount');
            }
            
            if (!Schema::hasColumn('invoices', 'status')) {
                $table->string('status')->default('unpaid')->after('paid_amount');
            }
            
            if (!Schema::hasColumn('invoices', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('status');
            }
            
            if (!Schema::hasColumn('invoices', 'issue_date')) {
                $table->date('issue_date')->after('payment_method');
            }
            
            if (!Schema::hasColumn('invoices', 'due_date')) {
                $table->date('due_date')->after('issue_date');
            }
            
            if (!Schema::hasColumn('invoices', 'paid_date')) {
                $table->date('paid_date')->nullable()->after('due_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Drop foreign keys first
            if (Schema::hasColumn('invoices', 'customer_id')) {
                $table->dropForeign(['customer_id']);
                $table->dropColumn('customer_id');
            }
            if (Schema::hasColumn('invoices', 'billing_id')) {
                $table->dropForeign(['billing_id']);
                $table->dropColumn('billing_id');
            }
            if (Schema::hasColumn('invoices', 'payment_id')) {
                $table->dropForeign(['payment_id']);
                $table->dropColumn('payment_id');
            }
            
            // Drop other columns
            $columnsToCheck = [
                'package_name', 'amount', 'paid_amount', 'status',
                'payment_method', 'issue_date', 'due_date', 'paid_date'
            ];
            
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('invoices', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};