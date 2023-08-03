<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string | int>
     */
    protected $fillable = [
        'title',
        'description',
        'poster_url',
        'floor_area',
        'type',
        'price',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'facility_rooms', 'room_id', 'facility_id');
    }

    public static function isAvailable($room_id, $start_date, $end_date) {
        $rooms = DB::table('bookings')
        ->where('room_id', $room_id)
        ->whereRaw(
            '(started_at >= ? AND started_at < ?) OR (finished_at > ? AND finished_at <= ?)
            ',
            [$start_date, $end_date, $start_date, $end_date]
        )->count();
        return $rooms === 0;
    }
}
