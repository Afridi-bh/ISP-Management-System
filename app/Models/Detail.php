<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'phone',
        'dob',
        'pin',
        'router_password',
        'router_name',
        'package_name',
        'package_price',
        'package_start',
        'due',
        'status',
        'user_id',
        'customer_id',
    ];

    protected $casts = [
        'dob' => 'date:Y-m-d',
        'package_start' => 'date',
        'package_price' => 'integer',
        'due' => 'integer',
    ];

    /**
     * Get the user that owns the detail
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the customer that owns the detail
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the owner (user or customer)
     */
    public function owner()
    {
        return $this->user_id ? $this->user : $this->customer;
    }
}