<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice',
        'package_name',
        'package_price',
        'package_start',
        'user_id',
        'status',
        'paid_amount',
        'due_amount',
    ];

    protected $casts = [
        'package_start' => 'date',
        'package_price' => 'integer',
        'paid_amount' => 'integer',
        'due_amount' => 'integer',
    ];

    /**
     * Boot method to set default values
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($billing) {
            if (!isset($billing->due_amount)) {
                $billing->due_amount = $billing->package_price;
            }
            if (!isset($billing->paid_amount)) {
                $billing->paid_amount = 0;
            }
            if (!isset($billing->status)) {
                $billing->status = 'unpaid';
            }
        });
    }

    /**
     * Get the user that owns the billing
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all payments for this billing
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Generate a random invoice number
     */
    public function generateRandomNumber()
    {
        return mt_rand(100000000, 999999999);
    }

    /**
     * Check if billing is paid
     */
    public function isPaid()
    {
        return $this->status === 'paid';
    }

    /**
     * Check if billing is unpaid
     */
    public function isUnpaid()
    {
        return $this->status === 'unpaid' || $this->status === 'pending';
    }

    /**
     * Check if billing is partially paid
     */
    public function isPartiallyPaid()
    {
        return $this->paid_amount > 0 && $this->paid_amount < $this->package_price;
    }

    /**
     * Get remaining amount to be paid
     */
    public function getRemainingAmount()
    {
        return $this->due_amount;
    }

    /**
     * Mark billing as paid
     */
    public function markAsPaid()
    {
        $this->update([
            'status' => 'paid',
            'paid_amount' => $this->package_price,
            'due_amount' => 0,
        ]);
    }

    /**
     * Update payment amounts
     */
    public function updatePayment($amount)
    {
        $newPaidAmount = $this->paid_amount + $amount;
        $newDueAmount = $this->package_price - $newPaidAmount;
        
        $this->update([
            'paid_amount' => $newPaidAmount,
            'due_amount' => $newDueAmount,
            'status' => $newDueAmount <= 0 ? 'paid' : ($newPaidAmount > 0 ? 'partial' : 'unpaid'),
        ]);
    }
}