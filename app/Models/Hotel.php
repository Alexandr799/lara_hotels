<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public static function hotelsWithFacilitiesAndPrice(array $params)
    {
        $minPrice = $params['min_price'] ?? null;
        $maxPrice = $params['max_price'] ?? null;
        $facilitiesList = $params['facilitiesList'] ?? [];

        $hotels = DB::table('hotels')
            ->join('rooms', 'hotels.id', '=', 'rooms.hotel_id')
            ->joinSub(
                function ($query) {
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
