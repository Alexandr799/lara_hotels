<?php

namespace App\Http\Controllers;

use App\Mail\AcceptMail;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    function index()
    {
        $bookings = Booking::where([
            'user_id' => Auth::id(),
        ])->simplePaginate(5);
        return view('bookings.index', ['bookings' => $bookings]);
    }

    function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'started_at' => ['required', 'date', 'date_format:Y-m-d', 'required_with:end_date'],
                'finished_at' => ['required', 'date', 'date_format:Y-m-d', 'required_with:start_date', 'after:start_date'],
                'room_id' => [
                    'required',
                    'exists:rooms,id',
                    function ($attribute, $value, $fail) use ($request) {
                        $start_date = $request->input('started_at');
                        $end_date = $request->input('finished_at');
                        if (!Room::isAvailable($value, $start_date, $end_date)) {
                            $fail('The selected room is not available for the specified period.');
                        }
                    }
                ]
            ]
        )->stopOnFirstFailure();

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        $date1 = new \DateTime($request->input('started_at'));
        $date2 = new \DateTime($request->input('finished_at'));
        $dayDiff = $date1->diff($date2)->days;
        $roomId = $request->input('room_id');

        $book = new Booking([
            'started_at' => $request->input('started_at'),
            'finished_at' => $request->input('finished_at'),
            'days' => $dayDiff,
            'price' => Room::find($roomId)->price * $dayDiff,
            'room_id' => $roomId,
            'user_id' => $user->id,
        ]);

        $book->save();

        Mail::to($user)->send(new AcceptMail($book, $user->name));

        return view('bookings.success', ['book_id' => $book->id]);
    }

    function show(Booking $booking, Request $request)
    {
        $user = Auth::user();
        return view('bookings.show', [
            'booking' => $booking,
            'email' => $user->email,
            'name' => $user->name,
        ]);
    }

    function delete(Request $request)
    {
        $request->validate([
            "booking_id" => ['required']
        ]);

        Booking::where([
            'user_id' => Auth::user()->id,
            'id' => $request->get('booking_id')
        ])->delete();

        return view('bookings.delete');
    }
}
