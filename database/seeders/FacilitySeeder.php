<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomAmenities = [
            'Air conditioning',
            'Balcony',
            'Bathtub',
            'Coffee maker',
            'Desk',
            'Flat-screen TV',
            'Free toiletries',
            'Hairdryer',
            'In-room safe',
            'Iron and ironing board',
            'Kitchenette',
            'Microwave',
            'Mini bar',
            'Patio',
            'Refrigerator',
            'Shower',
            'Slippers',
            'Sofa',
            'Telephone',
            'Wardrobe or closet',
            'WiFi',
            'Bathrobe',
            'DVD player',
            'Fireplace',
            'Kitchen',
            'Mountain view',
            'Private bathroom',
            'Sea view',
            'Soundproofing',
            'Tea/Coffee maker',
            'Whirlpool bathtub',
            'Work desk',
            'Bathroom',
            'City view',
            'Electric kettle',
            'Garden view',
            'Lake view',
            'Pool view',
            'Terrace',
            'TV',
            'Wake-up service',
            'Wooden/parquet floor',
        ];

        $facilities = [];

        foreach ($roomAmenities as $title) {
            $facility = new Facility(['title' => $title]);
            $facility->save();
            $facilities[] = $facility;
        }

        $hotels = Hotel::all();

        foreach ($hotels as $hotel) {
            $selectedFacilities = collect($facilities)->shuffle()->take(rand(3, 10));
            $hotel->facilities()->saveMany($selectedFacilities);
        }

        $rooms = Room::all();

        foreach ($rooms as $room) {
            $selectedFacilities = collect($facilities)->shuffle()->take(rand(3, 10));
            $room->facilities()->saveMany($selectedFacilities);
        }
    }
}
