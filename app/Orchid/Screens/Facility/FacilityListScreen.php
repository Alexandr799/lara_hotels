<?php

namespace App\Orchid\Screens\Facility;

use App\Models\Facility;
use App\Orchid\Layouts\Facility\FacilityListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class FacilityListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'facilities' => Facility::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Facilities list';
    }

    public function commandBar(): array
    {
        return [
            Link::make('Create')
                ->icon('pencil')
                ->route('platform.facility.edit')
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
            FacilityListLayout::class
        ];
    }
}
