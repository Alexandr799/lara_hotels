<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Database\Factories\HotelFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hotel::factory(30)->create();
    }
}
