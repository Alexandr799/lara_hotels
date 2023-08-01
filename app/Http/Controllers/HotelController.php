<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class HotelController extends Controller
{
    function index(Request $request)
    {
        $request->validate([
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
            'facilities' => ['array', 'exists:facilities,title']
        ]);

        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $facilitiesChecked =  $request->get('facilities', []);
        $minPrice = $request->get('min_price', null);
        $maxPrice = $request->get('max_price', null);

        $hotels = Hotel::hotelsWithFacilitiesAndPrice([
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'facilitiesList' =>  $facilitiesChecked
        ])->get()->map(function ($hotel) {
            $hotel->facilities = explode(',', $hotel->facilities);
            return $hotel;
        });

        $paginatedHotels = new LengthAwarePaginator(
            $hotels->forPage($currentPage, $perPage),
            $hotels->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url()]
        );

        $paginatedHotels->appends([
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'facilities' => $facilitiesChecked,
        ]);

        $facilities =  Facility::all('title');

        $params = [
            'hotels' => $paginatedHotels,
            'minPrice' => $minPrice,
            'maxPrice' =>  $maxPrice,
            'facilities' => $facilities,
            'facilitiesChecked' => $facilitiesChecked
        ];

        return view('hotels.index', $params);
    }
}
