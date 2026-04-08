<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Package
 *
 * @mixin Eloquent
 */
class Package extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'router_id'];

    /**
     * Get the router that owns the package
     */
    public function router() {
        return $this->belongsTo(Router::class);
    }

    /**
     * Get users with this package through details table
     */
    public function users()
    {
        return $this->hasManyThrough(
            User::class,
            Detail::class,
            'package_name', // Foreign key on details table
            'id',           // Foreign key on users table
            'name',         // Local key on packages table
            'user_id'       // Local key on details table
        );
    }

    /**
     * Get all details for this package
     */
    public function details()
    {
        return $this->hasMany(Detail::class, 'package_name', 'name');
    }

    /**
     * Get count of active users for this package
     */
    public function activeUsersCount()
    {
        return $this->details()->where('status', 'active')->whereNotNull('user_id')->count();
    }

    /**
     * Get count of total users for this package
     */
    public function totalUsersCount()
    {
        return $this->details()->whereNotNull('user_id')->count();
    }

    /**
     * Get total due amount for this package
     */
    public function totalDue()
    {
        return $this->details()->whereNotNull('user_id')->sum('due');
    }
}