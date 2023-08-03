<div {{ $attributes->merge(['class' => 'flex flex-col md:flex-row shadow-md']) }}>
    <div class="h-full w-full md:w-2/5">
        <div class="h-64 w-full bg-cover bg-center bg-no-repeat" style="background-image: url({{ $room->poster_url }})">
        </div>
    </div>
    <div class="p-4 w-full md:w-3/5 flex flex-col justify-between">
        <div class="pb-2">
            <div class="text-xl font-bold">
                {{ $room->name }}
            </div>
            <div>
               <span>•</span> {{ $room->floor_area }} м
            </div>
            <div>
                    @foreach($room->facilities as $facility)
                        <span>• {{ $facility->title }} </span>
                    @endforeach
            </div>
        </div>
        <hr>
        <div class="flex justify-end pt-2">
            @php
                $date1 = request()->get('start_date', \Carbon\Carbon::now()->format('d-m-Y'));
                $date2 = request()->get('end_date', \Carbon\Carbon::now()->addDay()->format('d-m-Y'));
                // Создаем объекты DateTime для каждой даты
                $dateTime1 = new DateTime($date1);
                $dateTime2 = new DateTime($date2);
                // Вычисляем разницу между датами
                $interval = $dateTime1->diff($dateTime2);
                // Получаем разницу в днях
                $daysDifference = $interval->days;
            @endphp
            <div class="flex flex-col">
                <span class="text-lg font-bold">{{ $room->price * $daysDifference}} руб.</span>
                <span>за {{ $daysDifference }} ночей</span>
            </div>
            <form class="ml-4" method="POST" action="{{ route('bookings.store') }}">
                @csrf
                <input type="hidden" name="started_at"
                value="{{ request()->get('start_date', \Carbon\Carbon::now()->format('d-m-Y')) }}">
                <input
                type="hidden"
                name="finished_at"
                value="{{ request()->get('end_date', \Carbon\Carbon::now()->addDay()->format('d-m-Y')) }}">
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <x-the-button class=" h-full w-full">{{ __('Book') }}</x-the-button>
            </form>
        </div>
    </div>
</div>
