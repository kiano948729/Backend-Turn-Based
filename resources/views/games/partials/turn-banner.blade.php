<div class="rounded-lg px-5 py-3 text-center text-sm font-medium
    {{ $isMyTurn
        ? 'bg-green-50 border border-green-400 text-green-800'
        : 'bg-gray-100 border border-gray-300 text-gray-600' }}">
    @if($isMyTurn)
    <strong>Jouw beurt</strong> kies een actie
    @else
    Wachten op <strong>{{ $enemyPlayer->user->name }}</strong>...
    @endif
</div>