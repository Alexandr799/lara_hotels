<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Hotel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'poster_url',
        'address',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function priceMin()
    {
        return $this->hasMany(Room::class)->min('price');
    }

    public function priceMax()
    {
        return $this->hasMany(Room::class)->max('price');
    }

    public function facilities()
    {
        return $this->belongsToMany(
            Facility::class,
            'facility_hotels',
            'hotel_id',
            'facility_id'
        );
    }

    public static function hotelsPrice(Request $request, $type = 'min')
    {
        $minPrice = $request->get('min_price', null);
        $maxPrice = $request->get('max_price', null);
        $facilitiesList =  $request->get('facilitiesList', []);

        $hotels = DB::table('hotels')
            ->join('rooms', 'hotels.id', '=', 'rooms.hotel_id')
            ->join('facility_hotels', 'hotels.id', '=', 'facility_hotels.hotel_id')
            ->join('facilities', 'facility_hotels.facility_id', '=', 'facilities.id')
            ->select(DB::raw("MIN(rooms.price) as price"))
            ->groupBy('hotels.id');

        if (isset($minPrice)) {
            $hotels->havingRaw('price > ?', [$minPrice]);
        }

        if (isset($maxPrice)) {
            $hotels->havingRaw('price > ?', [$maxPrice]);
        }

        if (count($facilitiesList) > 0) {
            $hotels->whereIn('facilities.title', $facilitiesList);
        }
        if ($type === 'min') {
            return $hotels->orderBy('price')->pluck('price')->first();
        } else {
            return $hotels->orderByDesc('price')->pluck('price')->first();
        }
    }

    public static function hotelsWithFacilitiesAndPrice(Request $request)
    {
        $minPrice = $request->get('min_price', null);
        $maxPrice = $request->get('max_price', null);
        $facilitiesList =  $request->get('facilities', []);

        $hotels = DB::table('hotels')
            ->join('rooms', 'hotels.id', '=', 'rooms.hotel_id')
            ->joinSub(
                function ($query) use ($facilitiesList) {
                    $query->select(
                        'hotel_id',
                        DB::raw('GROUP_CONCAT(facilities.title SEPARATOR ",") AS title')
                    )
                        ->from('facility_hotels')
                        ->join('facilities', 'facility_hotels.facility_id', '=', 'facilities.id')
                        ->groupBy('hotel_id');
                },
                'facilities',
                'hotels.id',
                '=',
                'facilities.hotel_id'
            )
            ->select(
                'hotels.id as id',
                'hotels.title as name',
                'hotels.address as address',
                'hotels.poster_url as poster_url',
                DB::raw('MIN(rooms.price) as price'),
                'facilities.title as facilities'
            )
            ->groupBy('hotels.id');

        if (isset($minPrice)) {
            $hotels->havingRaw('price > ?', [$minPrice]);
        }

        if (isset($maxPrice)) {
            $hotels->havingRaw('price < ?', [$maxPrice]);
        }

        foreach ($facilitiesList as $facility) {
            $hotels->havingRaw(
                "CONCAT(',',facilities, ',') LIKE ?",
                ['%' . ',' .  $facility . ',' . '%']
            );
        }

        return $hotels;
    }
}
