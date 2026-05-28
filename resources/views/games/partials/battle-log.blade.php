<div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-xl">

    <h3 class="text-white text-lg font-bold mb-4">
        Battle Log
    </h3>

    <div class="space-y-2 max-h-64 overflow-y-auto pr-2" id="battleLog">

        @forelse($game->logs()->latest()->take(20)->get()->reverse() as $log)

            <div class="bg-[#1f2937] rounded-lg px-4 py-3 text-sm border border-gray-700">

                <span class="text-gray-500 text-xs block mb-1">
                    {{ $log->created_at->format('H:i:s') }}
                </span>

                <span class="
                            {{ $log->action === 'attack' ? 'text-red-400' : '' }}
                            {{ $log->action === 'defend' ? 'text-blue-400' : '' }}
                            {{ $log->action === 'win' ? 'text-yellow-400 font-bold' : '' }}
                        ">
                    {{ $log->message }}
                </span>

            </div>

        @empty

            <p class="text-gray-500 text-sm">
                Het gevecht begint...
            </p>

        @endforelse

    </div>
</div>

<script>
    const log = document.getElementById('battleLog');

    if (log) {
        log.scrollTop = log.scrollHeight;
    }
</script>