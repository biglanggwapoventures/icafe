<?php

namespace App;

use App\CafeBranch;
use App\PCReservation;
use Carbon\Carbon;
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

    public function scopeWithReservationsOn($query, $date)
    {
        return $query->with(['reservations' => function ($q) use ($date) {
            $q->where('reservation_date', $date);
        }]);
    }

    public function cafeBranch()
    {
        return $this->belongsTo(CafeBranch::class, 'cafe_branch_id');
    }

    public function flagConflict(Carbon $requestStart, Carbon $requestEnd)
    {
        $conflicts = $this->reservations->filter(function ($item) use ($requestStart, $requestEnd) {

            $start = Carbon::parse($item->reservation_time);
            $end = $start->copy()->addHours($item->duration_in_hours);

            return $requestStart->between($start, $end) || $requestEnd->between($start, $end);
        });

        // $this->conflicts = $conflicts->isNotEmpty();

        return $conflicts->isNotEmpty();
    }

    public function is($status)
    {
        return $this->status === strtolower($status);
    }
}
