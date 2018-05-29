<?php

namespace App;

use App\Cafe;
use Illuminate\Database\Eloquent\Model;

class CafeBranch extends Model
{
    protected $fillable = [
        'cafe_id',
        'address',
        'latitude',
        'longitude',
        'contact_number',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }
}
