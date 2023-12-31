<?php

namespace App\Orchid\Screens\Room;

use App\Models\Facility;
use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;

class RoomEditScreen extends Screen
{
    public $room;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param Room $room
     * @return array
     */
    public function query(Room $room): array
    {
        return [
            'room' => $room,
            'facilities' =>  Facility::pluck('title', 'id')->all(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->room->exists ? 'Edit room' : 'Creating a new room';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create room')
                ->icon('pencil')
                ->method('create')
                ->canSee(!$this->room->exists),

            Button::make('Update')
                ->icon('note')
                ->method('update')
                ->canSee($this->room->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->room->exists),
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
                Input::make('room.title')
                    ->title('Title')
                    ->maxlength(100)
                    ->required()
                    ->placeholder('Input title room'),

                Relation::make('room.facilities')
                    ->title('Facilities')
                    ->multiple()
                    ->placeholder('Facilities input')
                    ->fromModel(Facility::class, 'title', 'id'),

                Relation::make('room.hotel_id')
                    ->title('Hotel')
                    ->required()
                    ->placeholder('Choise hotel')
                    ->fromModel(Hotel::class, 'title'),

                TextArea::make('room.description')
                    ->rows(3)
                    ->title('Description')
                    ->placeholder('Input description room'),

                Input::make('room.poster_url')
                    ->title('Poster URL')
                    ->type('file')
                    ->placeholder('Input poster'),

                Input::make('room.floor_area')
                    ->title('Floor Area')
                    ->type('number')
                    ->step(0.01)
                    ->required()
                    ->placeholder('Input floor area'),

                Input::make('room.type')
                    ->title('Type')
                    ->maxlength(100)
                    ->required()
                    ->placeholder('Input room type'),

                Input::make('room.price')
                    ->title('Price')
                    ->type('number')
                    ->required()
                    ->placeholder('Input room price'),
            ])
        ];
    }

    public function create(Request $request)
    {
        $request->validate([
            'room.poster_url' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $data = $request->get('room');
        $file = $request->file('room.poster_url');
        $name = uniqid() . '_' . $file->getClientOriginalName();
        $file->storeAs('public',  $name);
        $new_poster_url = "/storage/$name";
        $data['poster_url'] = $new_poster_url;



        $room = new Room($data);
        $room->save();


        $facilities = $request->get('room')['facilities'] ?? [];
        $room->facilities()->detach();
        $room->facilities()->attach($facilities);

        Alert::info('You have successfully created a room.');

        return redirect()->route('platform.room.list');
    }

    public function update(Room $room, Request $request)
    {
        $request->validate([
            'room.poster_url' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $data = $request->get('room');
        if ($request->hasFile('room.poster_url')) {
            $file = $request->file('room.poster_url');
            $name = uniqid() . '_' . $file->getClientOriginalName();
            $file->storeAs('public',  $name);
            $new_poster_url = "/storage/$name";

            $filename = str_replace('/storage/', '', $room->poster_url);
            Storage::delete('public' . $filename);
            $data['poster_url'] = $new_poster_url;
        } else {
            unset($data['poster_url']);
        }

        $room->fill($data)->save();

        $facilities = $request->get('room')['facilities'] ?? [];
        $room->facilities()->detach();
        $room->facilities()->attach($facilities);

        Alert::info('You have successfully updated a room.');

        return redirect()->route('platform.room.list');
    }

    public function remove(Room $room)
    {

        $filename = str_replace('/storage/', '', $room->poster_url);
        Storage::delete('public/' . $filename);


        $room->delete();

        Alert::info('You have successfully deleted the room.');

        return redirect()->route('platform.room.list');
    }
}
