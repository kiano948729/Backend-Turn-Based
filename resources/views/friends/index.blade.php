<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Vrienden</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 rounded-lg px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-300 text-red-800 rounded-lg px-4 py-3 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Vriend toevoegen</h3>
                <p class="text-sm text-gray-500 mb-4">Zoek op gebruikersnaam of e-mailadres.</p>

                <form method="POST" action="{{ route('friends.store') }}" class="flex gap-3">
                    @csrf
                    <input type="text" name="search" placeholder="Naam of e-mail..."
                        class="flex-1 border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 text-sm"
                        value="{{ old('search') }}" />
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
                        Uitnodigen
                    </button>
                </form>
            </div>

            @if($incoming->count())
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Openstaande verzoeken ({{ $incoming->count() }})
                    </h3>

                    <div class="space-y-3">
                        @foreach($incoming as $request)
                            <div
                                class="flex items-center justify-between bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-800 font-medium">{{ $request->user->name }}</span>

                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('friends.accept', $request) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white text-sm px-3 py-1.5 rounded-lg transition">
                                            Accepteren
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('friends.decline', $request) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm px-3 py-1.5 rounded-lg transition">
                                            Weigeren
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Mijn vrienden</h3>

                @forelse($accepted as $friendship)
                    @php
                        //laat de andere persoon zien, niet jezelf
                        $friend = $friendship->user_id === Auth::id()
                            ? $friendship->friendUser
                            : $friendship->user;
                    @endphp

                    <div
                        class="flex items-center justify-between bg-gray-50 rounded-lg px-4 py-3 border border-gray-200 mb-3">
                        <span class="text-gray-800 font-medium">{{ $friend->name }}</span>
                        <span class="text-gray-400 text-sm">{{ $friend->email }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Je hebt nog geen vrienden toegevoegd.</p>
                @endforelse
            </div>

        </div>
    </div>

</x-app-layout>