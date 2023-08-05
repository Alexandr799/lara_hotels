<?php

namespace App\Orchid\Screens\Facility;

use App\Models\Facility;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;

class FacilityEditScreen extends Screen
{
    public $facility;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param Facility $facility
     * @return array
     */
    public function query(Facility $facility): array
    {
        return [
            'facility' => $facility,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->facility->exists ? 'Edit facility' : 'Creating a new facility';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create')
                ->icon('pencil')
                ->method('create')
                ->canSee(!$this->facility->exists),

            Button::make('Update')
                ->icon('note')
                ->method('update')
                ->canSee($this->facility->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->facility->exists),
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
            Layout::rows([
                Input::make('facility.title')
                    ->title('Title')
                    ->maxlength(100)
                    ->required()
                    ->placeholder('Input title facility'),
            ])
        ];
    }

    public function create(Request $request)
    {
        $facility = new Facility($request->get('facility'));
        $facility->save();

        Alert::info('You have successfully created a facility.');

        return redirect()->route('platform.facility.list');
    }

    public function update(Facility $facility, Request $request)
    {
        $facility->fill($request->get('facility'))->save();

        Alert::info('You have successfully created a facility.');

        return redirect()->route('platform.facility.list');
    }


    public function remove(Facility $facility)
    {
        $facility->delete();

        Alert::info('You have successfully deleted the facility.');

        return redirect()->route('platform.facility.list');
    }
}
