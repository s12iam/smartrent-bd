<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    protected $fillable = [
    'property_id',
    'tenant_id',
    'owner_id',
    'start_date',
    'end_date',
    'rent_amount',
    'status',
];
public function property()
{
    return $this->belongsTo(Property::class);
}

public function tenant()
{
    return $this->belongsTo(User::class, 'tenant_id');
}

public function owner()
{
    return $this->belongsTo(User::class, 'owner_id');
}
    //
}
