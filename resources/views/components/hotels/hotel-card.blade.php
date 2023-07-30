<div class="bg-white rounded shadow-md flex card text-grey-darkest">
    <img class="w-1/2 h-full rounded-l-sm" src="{{ $hotel->poster_url }}" alt="Hotel Image">
    <div class="w-full flex flex-col justify-between p-4">
        <div>
            <a class="block text-grey-darkest mb-2 font-bold"
                href="{{ route('hotels.show', ['hotel' => $hotel->id]) }}">{{
                $hotel->name }}</a>
            <div class="text-xs">
                {{ $hotel->address }}
            </div>
        </div>
        <div class="pt-2">
            от <span class="text-2xl text-grey-darkest">{{ $hotel->price }} ₽</span>
            <span class="text-lg"> за ночь</span>
        </div>
        @php
            $facilitiesArray = explode(',', $hotel->facilities);
        @endphp
        @if(count($facilitiesArray) > 0)
        <div class="flex items-center py-2">
            @foreach(explode(',', $hotel->facilities) as $key=>$title)
            @if ($key<2)
                <div class="pr-2 text-xs">
                    <span>•</span> {{ $title }}
                 </div>
            @endif
        @endforeach
    </div>
    @endif
    <div class="flex justify-end">
        <x-link-button href="{{ route('hotels.show', ['hotel' => $hotel->id]) }}">Подробнее</x-link-button>
    </div>
</div>
</div>
