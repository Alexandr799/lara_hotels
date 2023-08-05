<?php

namespace App\Orchid\Layouts\Hotel;

use App\Models\Hotel;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class HotelListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'hotels';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')
                ->render(function (Hotel $hotel) {
                    return Link::make($hotel->id)
                        ->route(
                            'platform.booking.edit',
                            ['booking' => $hotel->id]
                        );
                }),
            TD::make('title', 'Title'),
            TD::make('address', 'Address'),
            TD::make('poster_url', 'Poster'),
            TD::make('created_at', 'Created'),
            TD::make('updated_at', 'Last edit'),
        ];
    }
}
