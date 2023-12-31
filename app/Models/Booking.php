<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Booking extends Model
{
    use HasFactory, AsSource;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string | int>
     */
    protected $fillable = [
        'started_at',
        'finished_at',
        'days',
        'price',
        'room_id',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
