<?php

namespace App;

use App\User;
use DB;
use Illuminate\Database\Eloquent\Model;

class CreditLog extends Model
{
    protected $fillable = [
        'client_id',
        'cafe_branch_id',
        'loaded_by',
        'pc_reservation_id',
        'credit',
        'debit',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'loaded_by');
    }

    public function cafeBranch()
    {
        return $this->belongsTo(CafeBranch::class);
    }

    public function scopeFieldsForMasterList($query)
    {
        return $query->with('client:id,name')->latest();
    }

    public function scopeOf($query, $userId)
    {
        return $query->whereClientId($userId)
            ->select('*')
            ->addSelect(DB::raw("(SELECT SUM(sub.credit-sub.debit) FROM credit_logs AS sub WHERE sub.id <= credit_logs.id AND client_id = {$userId}) AS running_balance"))
            ->whereClientId($userId)
            ->with(['cafeBranch:id,address,cafe_id', 'cafeBranch.cafe:id,name'])
            ->latest();
    }
}
