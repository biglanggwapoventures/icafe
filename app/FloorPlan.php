<?php

namespace App;

use App\CafeBranch;
use App\PCReservation;
use DB;
use Illuminate\Database\Eloquent\Model;

class FloorPlan extends Model
{
    protected $fillable = [
        'x',
        'y',
        'name',
        'status',
        'cafe_branch_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Returns a formatted collection of pc coordinates
     *
     * @return Collection
     */
    public function scopeFormattedCoordinates($query)
    {
        return $query->get()
            ->groupBy('y')
            ->mapWithKeys(function ($xCoords, $yValue) {
                return [$yValue => $xCoords->keyBy('x')];
            });
    }

    /**
     * Filter by cafe_branch_id
     *
     * @param  Builder $query
     * @param  int $cafeBranchId
     * @return Builder
     */
    public function scopeOf($query, $cafeBranchId)
    {
        return $query->whereCafeBranchId($cafeBranchId);
    }

    public function reservations()
    {
        return $this->hasMany(PCReservation::class);
    }

    public function todaysReservations()
    {
        return $this->reservations()->whereReservationDate(DB::raw('CURDATE()'));
    }

    public function cafeBranch()
    {
        return $this->belongsTo(CafeBranch::class, 'cafe_branch_id');
    }
}
