<?php

namespace App;

use App\CreditLog;
use App\FloorPlan;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PCReservation extends Model
{
    const CREDIT_PER_HOUR = 15;

    protected $table = 'pc_reservations';

    protected $fillable = [
        'floor_plan_id',
        'user_id',
        'reservation_date',
        'reservation_time',
        'duration_in_hours',
    ];

    protected $appends = [
        'reservation_ends_at',
        'reservation_datetime',
        'credit',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pc()
    {
        return $this->belongsTo(FloorPlan::class, 'floor_plan_id');
    }

    public function getReservationDatetimeAttribute()
    {
        return "{$this->reservation_date} {$this->reservation_time}";
    }

    public function getReservationEndsAtAttribute()
    {
        return Carbon::parse($this->reservation_datetime)->addHours($this->duration_in_hours);
    }

    public function getCreditAttribute()
    {
        return self::CREDIT_PER_HOUR * $this->duration_in_hours;
    }

    public function scopeTodayFor($query, $cafeBranchId)
    {
        return $this->whereReservationDate(DB::raw('CURDATE()'))->whereCafeBrachId($cafeBranchId);
    }

    public function reservationTime($format = false)
    {
        $time = Carbon::parse($this->reservation_time);
        return $format ? $time->format($format) : $time;
    }

    public static function hasConflict($date, Carbon $requestStart, Carbon $requestEnd)
    {
        $result = self::select('id', 'reservation_time', 'duration_in_hours')
            ->whereReservationDate($date)
            ->get();

        if ($result->isEmpty()) {
            return false;
        }

        $conflicts = $result->filter(function ($item) use ($requestStart, $requestEnd) {

            $start = Carbon::parse($item->reservation_time);
            $end = $start->copy()->addHours($item->duration_in_hours);

            return $requestStart->between($start, $end) || $requestEnd->between($start, $end);
        });

        return $conflicts->isNotEmpty();
    }

    public function creditLog()
    {
        return $this->hasOne(CreditLog::class, 'pc_reservation_id');
    }

    public function deductCredits()
    {
        $this->load('pc');

        return $this->creditLog()->create([
            'pc_reservation_id' => $this->id,
            'cafe_branch_id' => $this->pc->cafe_branch_id,
            'client_id' => $this->user_id,
            'debit' => $this->credit,
        ]);
    }

    public static function requiredCredits($usageDuration)
    {
        return self::CREDIT_PER_HOUR * $usageDuration;
    }

    public function scopeOf($query, $userId)
    {
        return $query->whereUserId($userId);
    }
}
