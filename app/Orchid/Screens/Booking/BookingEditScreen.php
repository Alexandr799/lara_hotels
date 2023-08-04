<?php

namespace App\Orchid\Screens\Booking;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;

class BookingEditScreen extends Screen
{
    public $hotel;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Hotel $hotel): iterable
    {
        return [
            'hotel' => $hotel
        ];
    }


    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->hotel->exists ? 'Edit hotel' : 'Creating a new hotel';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create hotel')
                ->icon('pencil')
                ->method('create')
                ->canSee(!$this->hotel->exists),

            Button::make('Update')
                ->icon('note')
                ->method('update')
                ->canSee($this->hotel->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->hotel->exists),
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
                Input::make('booking.price')
                    ->title('Title')
                    ->maxlength(100)
                    ->required()
                    ->placeholder('Input title hotel'),

                Relation::make('booking.room_id')
                    ->title('Room')
                    ->fromModel(Room::class, 'title'),

                Relation::make('booking.user_id')
                    ->title('User')
                    ->fromModel(User::class, 'name'),
            ])
        ];
    }

    public function create(Request $request)
    {
        $hotel = new Hotel($request->get('hotel'));
        $hotel->save();

        Alert::info('You have successfully created a hotel.');

        return redirect()->route('platform.hotel.list');
    }

    public function update(Hotel $hotel, Request $request)
    {
        $hotel->fill($request->get('hotel'))->save();

        Alert::info('You have successfully created a hotel.');

        return redirect()->route('platform.hotel.list');
    }


    public function remove(Hotel $hotel)
    {
        $hotel->delete();

        Alert::info('You have successfully deleted the hotel.');

        return redirect()->route('platform.hotel.list');
    }
}
