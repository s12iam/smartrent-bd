<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'tenant_id', 'property_id', 'owner_id',
        'start_date', 'end_date', 'status', 'message'
    ];

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}