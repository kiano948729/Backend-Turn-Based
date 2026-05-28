<div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-xl">

    @if($game->status === 'finished')

        <p class="text-center text-gray-400">
            Het gevecht is afgelopen.
        </p>

    @elseif($isMyTurn)

        <div class="grid grid-cols-2 gap-4">

            <form method="POST" action="{{ route('battle.attack', $game) }}">
                @csrf

                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 active:scale-95 transition-all duration-150 text-white font-bold py-4 rounded-xl">
                    Aanvallen
                </button>
            </form>

            <form method="POST" action="{{ route('battle.defend', $game) }}">
                @csrf

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 active:scale-95 transition-all duration-150 text-white font-bold py-4 rounded-xl">
                    Verdedigen
                </button>
            </form>

        </div>

    @else

        <div class="grid grid-cols-2 gap-4">

            <button disabled class="w-full bg-gray-800 text-gray-500 font-bold py-4 rounded-xl cursor-not-allowed">
                Aanvallen
            </button>

            <button disabled class="w-full bg-gray-800 text-gray-500 font-bold py-4 rounded-xl cursor-not-allowed">
                Verdedigen
            </button>

        </div>

        <p class="text-center text-gray-500 text-sm mt-4">
            Wachten op {{ $enemyPlayer->user->name }}
        </p>

    @endif
</div>