<?php

namespace App;

use App\CafeBranch;
use App\User;
use Illuminate\Database\Eloquent\Model;

class CafeAdmin extends Model
{
    protected $fillable = [
        'user_id',
        'cafe_branch_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cafeBranch()
    {
        return $this->belongsTo(CafeBranch::class);
    }

    public function scopeFieldsForMasterList($query)
    {
        return $query->with(['cafeBranch.cafe', 'user']);
    }

}
