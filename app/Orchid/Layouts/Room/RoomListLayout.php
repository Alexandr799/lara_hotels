<?php

namespace App\Orchid\Layouts\Room;

use App\Models\Hotel;
use App\Models\Room;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class RoomListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'rooms';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')
                ->render(function (Room $room) {
                    return Link::make($room->id)
                        ->route(
                            'platform.room.edit',
                            ['room' => $room->id]
                        );
                }),

            TD::make('title', 'Title'),
            TD::make('floor_area', 'Floor Area'),
            TD::make('type', 'Type'),
            TD::make('price', 'Price'),
            TD::make('hotel_id', 'Hotel')
                ->render(function (Room $room) {
                    return  $room->hotel->title;
                }),
        ];
    }
}
