<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('games.store') }}" class="flex items-center gap-4">
        @csrf

        <select name="game_class_id" class="rounded-xl border-gray-300">

            @foreach($classes as $class)

                <option value="{{ $class->id }}">
                    {{ $class->name }}
                </option>

            @endforeach

        </select>

        <button class="bg-red-600 text-white px-4 py-2 rounded-xl">
            Create Game
        </button>

    </form>
</x-app-layout>