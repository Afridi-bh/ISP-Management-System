<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'message', 'status', 'priority', 'number', 'ticketable_id', 'ticketable_type'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Polymorphic relationship - can belong to User or Customer
    public function ticketable()
    {
        return $this->morphTo();
    }

    // Helper method to get the creator (user or customer)
    public function creator()
    {
        return $this->ticketable;
    }

    // Check if ticket is from a customer
    public function isCustomerTicket()
    {
        return $this->ticketable_type === 'App\\Models\\Customer';
    }

    // Check if ticket is from a user (admin/staff)
    public function isUserTicket()
    {
        return $this->ticketable_type === 'App\\Models\\User';
    }

    public function generateRandomNumber()
    {
        try {
            $number = random_int(100000, 999999);
        } catch (\Exception $e) {
            $number = mt_rand(100000, 999999);
        }
        
        if (self::where('number', $number)->exists()) {
            return $this->generateRandomNumber();
        }
        
        return $number;
    }
}