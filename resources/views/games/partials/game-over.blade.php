<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-10 text-center max-w-sm w-full mx-4">

        <h2 class="text-2xl font-bold mb-1 {{ $iWon ? 'text-green-700' : 'text-red-700' }}">
            {{ $iWon ? 'Gewonnen' : 'Verloren' }}
        </h2>

        <p class="text-gray-500 text-sm mb-6">
            @if($iWon)
                Je hebt gewonnen
            @else
                {{ $enemyPlayer->user->name }} heeft jou verslagen
            @endif
        </p>

        <a href="{{ route('dashboard') }}"
            class="block w-full bg-gray-900 hover:bg-gray-700 text-white font-semibold py-2.5 rounded-lg transition">
            Terug naar lobby
        </a>
    </div>
</div>