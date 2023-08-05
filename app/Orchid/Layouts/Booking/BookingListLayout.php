<?php

namespace App\Orchid\Layouts\Booking;

use App\Models\Booking;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class BookingListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'bookings';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')
                ->render(function (Booking $booking) {
                    return Link::make($booking->id)
                        ->route(
                            'platform.booking.edit',
                            ['booking' => $booking->id]
                        );
                }),

            TD::make('price', 'Price'),
            TD::make('days', 'Nights count'),
            TD::make('started_at', 'Сheck-in'),
            TD::make('updated_at', 'Сheck-out'),
            TD::make('updated_at', 'User')
                ->render(function (Booking $booking) {
                    return  $booking->user->name;
                }),

            TD::make('updated_at', 'Room')
                ->render(function (Booking $booking) {
                    return  $booking->room->title;
                }),
        ];
    }
}
