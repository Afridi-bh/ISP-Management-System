<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'billing_id',
        'payment_id',
        'package_name',
        'amount',
        'paid_amount',
        'status',
        'payment_method',
        'issue_date',
        'due_date',
        'paid_date',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // Helper methods
    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isUnpaid()
    {
        return $this->status === 'unpaid';
    }

    public function isPartiallyPaid()
    {
        return $this->status === 'partial';
    }

    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->paid_amount;
    }
}