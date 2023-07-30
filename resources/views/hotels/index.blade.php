<x-layouts.app-layout>
    <div class="py-14 px-4 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">
        <div class="grid grid-cols-3 md:grid-cols-2 gap-4 my-4">
            <div>
                <form method="get" action="{{route('hotels.index')}}" novalidate
                    class="grid grid-cols-1  gap-4 p-5 rounded border-black border-2">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <h3 class="text-2xl font-semibold">Фильтры</h3>
                    <div>
                        <x-label for="min_price" :value="__('Min price')" />
                        <x-input min="0" id="min_price" class="block mt-1 w-full" type="number" name="min_price"
                            value="{{$minPrice}}" />
                    </div>
                    <div>
                        <x-label for="max_price" :value="__('Max price')" />
                        <x-input min="0" id="max_price" class="block mt-1 w-full" type="number" name="max_price"
                            value="{{$maxPrice}}" />
                    </div>
                    <div>
                        <x-dropdown align="left" type="submit" class=" h-full" :closeContentOnClick="true">
                            <x-slot name="trigger">
                                <x-the-button type="button" class=" h-full ">Список удобств</x-the-button>
                            </x-slot>

                            <x-slot name="content">
                                @foreach ($facilities as $facility)
                                <div>
                                    <label for="{{$facility->title . '_facilities'}}">
                                        <input value="{{$facility->title}}" @if (in_array($facility->title,
                                        $facilitiesChecked))
                                        checked
                                        @endif
                                        type="checkbox" name="facilities[]"
                                        id="{{$facility->title . '_facilities'}}">
                                        {{$facility->title}}
                                    </label>
                                </div>
                                @endforeach
                            </x-slot>
                        </x-dropdown>
                    </div>
                    <div class="grid-cols-1">
                        <x-the-button type="submit" class=" h-full ">Фильтровать отели</x-the-button>
                    </div>
                </form>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($hotels as $hotel)
            <x-hotels.hotel-card :hotel="$hotel"></x-hotels.hotel-card>
            @endforeach
        </div>
        <div class="container mx-auto my-6">
            {{ $hotels->links() }}
        </div>
    </div>
</x-layouts.app-layout>
