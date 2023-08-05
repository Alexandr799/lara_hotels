<?php

namespace App\Orchid\Screens\Booking;

use App\Models\Booking;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use App\Models\Room;
use App\Models\User;

class BookingEditScreen extends Screen
{
    public $booking;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Booking $booking): iterable
    {
        return [
            'booking' => $booking
        ];
    }


    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->booking->exists ? 'Edit booking' : 'Creating a new booking';
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
                ->canSee(!$this->booking->exists),

            Button::make('Update')
                ->icon('note')
                ->method('update')
                ->canSee($this->booking->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->booking->exists),
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
                    ->type('number')
                    ->title('Price')
                    ->placeholder('Input price for booking')
                    ->required(),

                Input::make('booking.days')
                    ->type('number')
                    ->title('Nights count')
                    ->placeholder('Input price for booking')
                    ->required(),

                DateTimer::make('booking.started_at')
                    ->format('Y-m-d')
                    ->title('Check-in')
                    ->required()
                    ->placeholder('Input date check-in'),

                DateTimer::make('booking.finished_at')
                    ->format('Y-m-d')
                    ->title('Check-out')
                    ->required()
                    ->placeholder('Input date check-out'),

                Relation::make('booking.room_id')
                    ->title('Room')
                    ->required()
                    ->placeholder('Choise room')
                    ->fromModel(Room::class, 'title'),

                Relation::make('booking.user_id')
                    ->title('User')
                    ->required()
                    ->placeholder('Choise user')
                    ->fromModel(User::class, 'name'),
            ])
        ];
    }

    public function create(Request $request)
    {
        $booking = new Booking($request->get('booking'));
        $booking->save();

        Alert::info('You have successfully created a booking.');

        return redirect()->route('platform.booking.list');
    }

    public function update(Booking $booking, Request $request)
    {
        $booking->fill($request->get('booking'))->save();

        Alert::info('You have successfully created a booking.');

        return redirect()->route('platform.booking.list');
    }


    public function remove(Booking $booking)
    {
        $booking->delete();

        Alert::info('You have successfully deleted the booking.');

        return redirect()->route('platform.booking.list');
    }
}
