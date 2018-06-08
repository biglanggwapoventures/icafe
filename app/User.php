<?php

namespace App;

use App\CreditLog;
use Auth;
use DB;
use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'address', 'contact_number', 'password', 'provider', 'provider_id', 'role', 'display_photo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at',
    ];

    public function login()
    {
        Auth::login($this);
    }

    public function setPasswordAttribute($val)
    {
        $this->attributes['password'] = Hash::make($val);
    }

    public function is($role)
    {
        return strtolower($role) === $this->role;
    }

    public function cafeAdmin()
    {
        return $this->hasOne(CafeAdmin::class);
    }

    public function creditLogs()
    {
        return $this->hasMany(CreditLog::class, 'client_id');
    }

    public function scopeOfRole($query, $role)
    {
        return $query->whereRole($role);
    }

    public function remainingCredits()
    {
        if (!$this->is('user')) {
            return 0;
        }

        if ($this->relationLoaded('creditLogs')) {
            return $this->creditLogs->sum(function ($row) {
                return $row->credit - $row->debit;
            });
        }

        return $this->creditLogs()->sum(DB::raw('credit - debit'));

    }
}
