<?php

namespace App\Orchid\Layouts\Facility;

use App\Models\Facility;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class FacilityListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'facilities';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')
                ->render(function (Facility $facility) {
                    return Link::make($facility->id)
                        ->route(
                            'platform.facility.edit',
                            ['facility' => $facility->id]
                        );
                }),

            TD::make('title', 'Title'),
        ];
    }
}
