<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $table = 'facilities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
    ];

    public function hotels()
    {
        return $this->belongsTo(Hotel::class, 'facility_hotels', 'facility_id', 'hotel_id');
    }

    public function rooms()
    {
        return $this->belongsTo(Hotel::class, 'facility_rooms', 'facility_id', 'room_id');
    }
}
