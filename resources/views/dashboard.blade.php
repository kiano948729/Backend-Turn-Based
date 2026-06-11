<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('error'))
                <div class="bg-red-100 border border-red-300 text-red-800 rounded-lg px-4 py-3 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if($activeGame)
                <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-5 flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-yellow-800">Je hebt een actief gevecht!</p>
                        <p class="text-sm text-yellow-600">Ga terug naar de arena.</p>
                    </div>
                    <a href="{{ route('games.show', $activeGame) }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Ga naar gevecht
                    </a>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Nieuw gevecht starten</h3>
                <p class="text-sm text-gray-500 mb-5">Kies een klasse en ga de arena in.</p>

                <form method="POST" action="{{ route('games.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="game_class_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Kies je klasse
                        </label>
                        <select name="game_class_id" id="game_class_id"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500">
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">
                                    {{ $class->name }} {{ $class->base_hp }} HP / {{ $class->base_mana }} Mana
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="friend_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Tegenstander (optioneel)
                        </label>
                        <select name="friend_id" id="friend_id"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500">
                            <option value="">Willekeurige speler</option>
                            @foreach($friends as $friend)
                                <option value="{{ $friend->id }}">{{ $friend->name }}</option>
                            @endforeach
                        </select>
                        @if($friends->isEmpty())
                            <p class="text-xs text-gray-400 mt-1">
                                Nog geen vrienden? <a href="{{ route('friends.index') }}"
                                    class="underline text-red-500">Voeg er een toe.</a>
                            </p>
                        @endif
                    </div>

                    @if($classes->isEmpty())
                        <p class="text-sm text-red-500 mb-3">
                            Geen klassen gevonden. Voer de seeder uit.
                        </p>
                    @endif

                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg transition">
                        Gevecht starten
                    </button>
                </form>
            </div>

        </div>
    </div>

</x-app-layout>