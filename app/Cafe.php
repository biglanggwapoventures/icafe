<?php

namespace App;

use App\CafeAdmin;
use App\CafeBranch;
use Illuminate\Database\Eloquent\Model;

class Cafe extends Model
{
    protected $fillable = [
        'name',
        'location',
        'location_latitude',
        'location_longitude',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function admins()
    {
        return $this->hasManyThrough(CafeAdmin::class, CafeBranch::class);
    }

    public function branches()
    {
        return $this->hasMany(CafeBranch::class);
    }

    public function scopeFieldsForMasterList($query)
    {
        return $query->orderBy('name');
    }
}
