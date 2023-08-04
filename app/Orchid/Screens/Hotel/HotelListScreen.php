<?php

namespace App\Orchid\Screens\Hotel;

use App\Models\Hotel;
use App\Orchid\Layouts\Hotel\HotelListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class HotelListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'hotels' => Hotel::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Hotels list';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create new')
                ->icon('pencil')
                ->route('platform.hotel.edit')
        ];
    }


    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            HotelListLayout::class
        ];
    }
}
