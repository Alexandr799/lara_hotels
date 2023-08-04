<x-layouts.app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" style="color: green;font-weight:500">
                    Бронирование успешно выполненно мы отправили вам на почту подтверждение.
                    Посмотреть информацию о брониронии или отменить его вы можете по ссылке
                    <a href="{{ route('bookings.show', ['booking'=>$book_id]) }}" class="text-blue-500">ссылке тут</a>
                </div>
            </div>
        </div>
    </div>
</x-layout.app-layout>
