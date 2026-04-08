<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guard = 'customer';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'status',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Active subscription
     */
    public function currentSubscription()
    {
        return $this->hasOne(Subscription::class)
                    ->where('status', 'active')
                    ->latest();
    }

    /**
     * Payments made by the customer
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Polymorphic tickets
     */
    public function tickets()
    {
        return $this->morphMany(Ticket::class, 'ticketable');
    }

    /**
     * Subscription check
     */
    public function hasActiveSubscription()
    {
        return $this->subscriptions()
                    ->where('status', 'active')
                    ->where('expires_at', '>', now())
                    ->exists();
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isSuspended()
    {
        return $this->status === 'suspended';
    }

    /**
     * Pending package request check
     */
    public function hasPendingRequest()
    {
        return $this->packageRequests()
                    ->where('status', 'pending')
                    ->exists();
    }

    /**
     * Customer detail info (profile)
     */
    public function detail()
    {
        return $this->hasOne(Detail::class, 'customer_id');
    }

    /**
     * Package requests
     */
    public function packageRequests()
    {
        return $this->hasMany(PackageRequest::class);
    }

    /**
     * All subscriptions
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Invoices
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    // In App/Models/Customer.php, add this method:

public function linkedUser()
{
    return $this->hasOne(User::class, 'email', 'email');
}
    
}
