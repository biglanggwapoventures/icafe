<?php

namespace App;

use App\Cafe;
use DB;
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

    public function scopeSearch($query, $search)
    {
        return $query->with('cafe')
            ->where(function ($q) use ($search) {
                $q->where('address', 'LIKE', "%{$search}%")
                    ->orWhereHas('cafe', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            });

    }

    public static function top()
    {
        $top = self::select(DB::raw('SUM(cl.credit) AS total_sales'), 'cafe_branches.id')
            ->leftJoin('credit_logs AS cl', 'cl.cafe_branch_id', '=', 'cafe_branches.id')
            ->groupBy('cafe_branches.id')
            ->orderBy('total_sales', 'DESC')
            ->get();

        return $top;
    }
}
