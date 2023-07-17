<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function price(){
        return $this->hasMany(Room::class)->min('price');
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
}
