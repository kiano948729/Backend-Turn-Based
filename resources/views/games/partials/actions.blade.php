@php
    $class = strtolower($currentPlayer->gameClass->name);

    $attacks = match ($class) {

        'mage' => [
            'fireball' => 'Fireball',
            'frost_nova' => 'Frost Nova',
            'arcane_blast' => 'Arcane Blast',
            'you_shall_not_pass' => 'You shall not pass',
        ],

        'warrior' => [
            'heavy_slash' => 'Heavy Slash',
            'shield_bash' => 'Shield Bash',
            'berserk' => 'Berserk',
        ],

        'rogue' => [
            'backstab' => 'Backstab',
            'poison_dagger' => 'Poison Dagger',
            'shadow_strike' => 'Shadow Strike',
        ],

        default => [],
    };
@endphp

<div class="border rounded p-4">

    @if($game->status === 'finished')

        <p>Het gevecht is voorbij.</p>

    @elseif($isMyTurn)

        <div class="flex flex-wrap gap-2">

            @foreach($attacks as $key => $label)

                <form method="POST" action="{{ route('battle.attack', [$game, $key]) }}">
                    @csrf

                    <button type="submit" class="border px-4 py-2 rounded">
                        {{ $label }}
                    </button>

                </form>

            @endforeach

            <form method="POST" action="{{ route('battle.defend', $game) }}">
                @csrf

                <button type="submit" class="border px-4 py-2 rounded">
                    Defend
                </button>

            </form>

        </div>

    @else

        <p>
            Wachten op {{ $enemyPlayer->user->name }}
        </p>

    @endif

</div>