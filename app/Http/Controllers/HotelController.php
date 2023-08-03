<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

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
        ])->get()->map(function ($hotel) use ($facilitiesChecked) {
            $hotel->facilities = explode(',', $hotel->facilities);
            $hotel->facilities = array_reverse(array_merge($hotel->facilities, $facilitiesChecked));
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

    function show($id, Request $request)
    {
        $request->validate([
            'start_date' => ['date', 'date_format:Y-m-d', 'required_with:end_date'],
            'end_date' => ['date', 'date_format:Y-m-d', 'required_with:start_date', 'after:start_date'],
        ]);

        $startDate = $request->get('start_date', date("Y-m-d"));
        $endDate = $request->get('end_date', date("Y-m-d", strtotime("+1 day", strtotime(date("Y-m-d")))));
        $hotel = Hotel::where([
            'id' => $id
        ])->first();

        $rooms = Room::where([
            'hotel_id' => $id
        ])->get();

        return view(
            'hotels.show',
            [
                'hotel' => $hotel,
                'rooms' => $rooms,
            ]
        );
    }
}
