<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    function index(Request $request)
    {
        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $hotels = Hotel::hotelsWithFacilitiesAndPrice($request);
        $facilitiesChecked =  $request->get('facilities', []);

        $minPrice = $request->get('min_price', null) ?? Hotel::hotelsPrice($request, 'min');
        $maxPrice = $request->get('max_price', null) ?? Hotel::hotelsPrice($request, 'max');
        $facilities =  Facility::all('title');

        $params = [
            'hotels' => $hotels->paginate($perPage, ['*'], 'page', $currentPage),
            'minPrice' => $minPrice,
            'maxPrice' =>  $maxPrice,
            'facilities' => $facilities,
            'facilitiesChecked' => $facilitiesChecked
        ];

        return view('hotels.index', $params);
    }
}
