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
            TD::make('title', 'Title')
                ->render(function (Hotel $hotel) {
                    return Link::make($hotel->title)
                        ->route(
                            'platform.hotel.edit',
                            ['hotel' => $hotel->id]
                        );
                }),

            TD::make('address', 'Address'),
            TD::make('poster_url', 'Poster'),
            TD::make('created_at', 'Created'),
            TD::make('updated_at', 'Last edit'),
        ];
    }
}
