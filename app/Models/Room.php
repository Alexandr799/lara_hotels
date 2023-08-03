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

    private static function bookingOnDate($start_date, $end_date)
    {

        $rooms = DB::table('bookings')
            ->where(function ($q) use ($start_date, $end_date) {
                $q->whereRaw('(started_at >= ? AND started_at < ?)', [$start_date, $end_date])
                    ->orWhereRaw('(finished_at > ? AND finished_at <= ?)', [$start_date, $end_date]);
            });
        return $rooms;
    }

    public static function isAvailable($room_id, $start_date, $end_date)
    {
        $rooms =  static::bookingOnDate($start_date, $end_date)
            ->where('room_id', $room_id)
            ->count();
        return $rooms === 0;
    }


    public static function getAvailableRoomsInHotel($hotel_id, $start_date, $end_date)
    {
        $ids =  static::bookingOnDate($start_date, $end_date)->pluck('room_id')->toArray();
        $rooms =  static::where('hotel_id', $hotel_id)->whereNotIn('id', $ids)->get();
        return $rooms;
    }
}
