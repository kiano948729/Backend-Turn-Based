@forelse($leaders as $i => $user)
    <div class="flex items-center justify-between bg-[#1f2937] rounded-lg px-4 py-2 mb-2 border border-gray-700">
        <span class="text-gray-400 text-sm w-5">{{ $i + 1 }}.</span>
        <span class="text-white text-sm flex-1 ml-2">{{ $user->name }}</span>
        <span class="text-yellow-400 font-bold text-sm">{{ $user->won_games_count }}W</span>
    </div>
@empty
    <p class="text-gray-500 text-sm">Nog geen winnaars.</p>
@endforelse