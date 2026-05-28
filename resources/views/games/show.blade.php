<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Arena</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            @include('games.partials.flash')

            @include('games.partials.turn-banner', ['isMyTurn' => $isMyTurn])

            @include('games.partials.combatants', [
                'currentPlayer' => $currentPlayer,
                'enemyPlayer' => $enemyPlayer,
            ])

            @include('games.partials.actions', [
                'game' => $game,
                'isMyTurn' => $isMyTurn,
                'enemyPlayer' => $enemyPlayer,
            ])

            @include('games.partials.battle-log', ['game' => $game])

        </div>
    </div>

    @if($game->status === 'finished')
        @include('games.partials.game-over', [
            'iWon' => $game->winner_id === Auth::id(),
            'enemyPlayer' => $enemyPlayer,
        ])
    @endif

    @if(!$isMyTurn && $game->status === 'active')
        <script>setTimeout(() => location.reload(), 4000);</script>
    @endif

</x-app-layout>