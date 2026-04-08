<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'comment', 'user_id', 'customer_id'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Helper to get the commenter (user or customer)
    public function commenter()
    {
        return $this->user ?? $this->customer;
    }

    public function isCustomerComment()
    {
        return $this->customer_id !== null;
    }
}