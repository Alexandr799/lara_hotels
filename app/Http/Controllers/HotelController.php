<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    function index(Request $request)
    {
        $request->validate([
            'min_price'=>['numeric', 'min:0'],
            'max_price'=>['numeric', 'min:1'],
            'facilities' => ['array','exists:facilities,title']
        ]);

        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $hotels = Hotel::hotelsWithFacilitiesAndPrice($request);
        $facilitiesChecked =  $request->get('facilities', []);

        $minPrice = $request->get('min_price', null);
        $maxPrice = $request->get('max_price', null);
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
