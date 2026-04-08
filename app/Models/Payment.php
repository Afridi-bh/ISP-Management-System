<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'billing_id',
        'invoice',
        'package_price',  // Your schema uses this instead of 'amount'
        'payment_method',
        'transaction_id',
        'status',
        'payment_date',
        'notes',
    ];

    protected $casts = [
        'package_price' => 'integer',
        'payment_date' => 'datetime',
    ];

    /**
     * Get the user that made the payment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the customer that made the payment
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the billing this payment is for
     */
    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }

    /**
     * Get the owner (user or customer)
     */
    public function owner()
    {
        return $this->user_id ? $this->user : $this->customer;
    }

    /**
     * Get owner name
     */
    public function getOwnerNameAttribute()
    {
        if ($this->user_id && $this->user) {
            return $this->user->name;
        } elseif ($this->customer_id && $this->customer) {
            return $this->customer->name;
        }
        return 'N/A';
    }

    /**
     * Scope for completed payments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for pending payments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for user payments
     */
    public function scopeUserPayments($query)
    {
        return $query->whereNotNull('user_id');
    }

    /**
     * Scope for customer payments
     */
    public function scopeCustomerPayments($query)
    {
        return $query->whereNotNull('customer_id');
    }
}