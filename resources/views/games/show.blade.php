<x-app-layout>

    <div class="max-w-6xl mx-auto p-6">

        <div class="flex justify-between items-center mb-10">

            <div>
                <h1 class="text-5xl font-bold">
                    Dungeon Duel
                </h1>

                <p class="text-gray-500 mt-2">
                    Game #{{ $game->id }}
                </p>
            </div>

            @if($game->status === 'finished')

                <div class="bg-green-100 text-green-700 px-6 py-3 rounded-xl font-bold">
                    Game Finished
                </div>

            @else

                <div class="bg-blue-100 text-blue-700 px-6 py-3 rounded-xl font-bold">
                    @if($game->current_turn_player_id === auth()->id())
                        Your Turn
                    @else
                        Enemy Turn
                    @endif
                </div>

            @endif

        </div>

        <div class="grid grid-cols-2 gap-8 mb-10">

            <div class="bg-white rounded-2xl shadow p-6">

                <div class="flex items-center justify-between mb-4">

                    <h2 class="text-3xl font-bold">
                        {{ auth()->user()->name }}
                    </h2>

                    <span class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full">
                        You
                    </span>

                </div>

                <div class="mb-4">

                    <div class="flex justify-between mb-2">
                        <span>HP</span>
                        <span>{{ $currentPlayer->current_hp }}/100</span>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-5 overflow-hidden">

                        <div class="bg-green-600 h-full transition-all duration-500"
                            style="width: {{ $currentPlayer->current_hp ?? 0 }}%;"></div>

                    </div>

                </div>

                <div>

                    <div class="flex justify-between mb-2">
                        <span>Mana</span>
                        <span>{{ $currentPlayer->current_mana }}/50</span>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-5 overflow-hidden">

                        <div class="bg-blue-600 h-full transition-all duration-500"
                            style="width: {{ ($currentPlayer->current_mana ?? 0) * 2 }}%;"></div>

                    </div>

                </div>

            </div>

            <div class="bg-white rounded-2xl shadow p-6">

                <div class="flex items-center justify-between mb-4">

                    <h2 class="text-3xl font-bold">
                        {{ $enemyPlayer->user->name }}
                    </h2>

                    <span class="text-sm bg-red-100 text-red-700 px-3 py-1 rounded-full">
                        Enemy
                    </span>

                </div>

                <div class="mb-4">

                    <div class="flex justify-between mb-2">
                        <span>HP</span>
                        <span>{{ $enemyPlayer->current_hp }}/100</span>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-5 overflow-hidden">

                        <div class="bg-red-600 h-full transition-all duration-500"
                            style="width: {{ $enemyPlayer->current_hp ?? 0 }}%;"></div>

                    </div>

                </div>

                <div>

                    <div class="flex justify-between mb-2">
                        <span>Mana</span>
                        <span>{{ $enemyPlayer->current_mana }}/50</span>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-5 overflow-hidden">

                        <div class="bg-blue-600 h-full transition-all duration-500"
                        style="{{ 'width:'.(($enemyPlayer->current_mana ?? 0) * 2).'%;' }}"></div>
                </div>

            </div>

        </div>

        @if($game->status !== 'finished')

            @if($game->current_turn_player_id === auth()->id())

                <div class="flex gap-4 mb-10">

                    <form method="POST" action="{{ route('battle.attack', $game) }}">
                        @csrf

                        <button class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-2xl font-bold transition">
                            Attack
                        </button>

                    </form>

                    <form method="POST" action="{{ route('battle.defend', $game) }}">
                        @csrf

                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-bold transition">
                            Defend
                        </button>

                    </form>

                </div>

            @endif

        @endif

        <div class="bg-white rounded-2xl shadow p-6">

            <h2 class="text-2xl font-bold mb-6">
                Battle Log
            </h2>

            <div class="space-y-3">

                @foreach($game->actions()->latest()->get() as $action)

                    <div class="border-b pb-3">

                        <div class="font-semibold">
                            {{ $action->user->name }}
                        </div>

                        <div class="text-gray-600">
                            {{ $action->description }}
                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</x-app-layout>