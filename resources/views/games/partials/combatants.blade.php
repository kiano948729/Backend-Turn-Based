@php
    $myHpPct = $currentPlayer->gameClass->base_hp > 0
        ? ($currentPlayer->current_hp / $currentPlayer->gameClass->base_hp * 100) : 0;

    $enemyHpPct = $enemyPlayer->gameClass->base_hp > 0
        ? ($enemyPlayer->current_hp / $enemyPlayer->gameClass->base_hp * 100) : 0;

    $myClass = strtolower($currentPlayer->gameClass->name);
    $enemyClass = strtolower($enemyPlayer->gameClass->name);
@endphp

<div class="bg-[url('../../public/gifs/background.gif')] bg-cover bg-center border border-gray-800 rounded-2xl p-8 shadow-2xl overflow-hidden">
    <!-- arena -->
    <div class="relative flex items-center justify-between gap-10 min-h-[320px]">

        <!-- speler -->
        <div class="w-1/2 flex flex-col items-center">

            <div class="mb-4 text-center">
                <h2 class="text-white text-2xl font-bold">
                    {{ Auth::user()->name }}
                </h2>

                <p class="text-gray-400 text-sm uppercase tracking-widest">
                    {{ $currentPlayer->gameClass->name }}
                </p>
            </div>

            <!-- gifs -->
            <div class="relative">
                <img src="{{ asset('gifs/' . $myClass . '.gif') }}" alt="{{ $currentPlayer->gameClass->name }}"
                    class="w-56 h-56 object-contain drop-shadow-[0_0_35px_rgba(255,255,255,0.15)]">

                @if($currentPlayer->is_defending)
                    <div class="absolute inset-0 border-4 border-blue-400 rounded-full animate-pulse"></div>
                @endif
            </div>

            <!-- hp -->
            <div class="w-full max-w-xs mt-6">
                <div class="flex justify-between text-sm text-gray-300 mb-2">
                    <span>HP</span>
                    <span>
                        {{ $currentPlayer->current_hp }}
                        /
                        {{ $currentPlayer->gameClass->base_hp }}
                    </span>
                </div>

                <div class="h-4 bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-full bg-green-500 transition-all duration-500" style="width: {{ $myHpPct }}%;"></div>
                </div>
            </div>
        </div>

        <!-- vs -->
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">

            <div class="text-5xl font-black text-white opacity-20 tracking-widest">
                VS
            </div>

        </div>

        <!-- tegenstander -->
        <div class="w-1/2 flex flex-col items-center">

            <div class="mb-4 text-center">
                <h2 class="text-white text-2xl font-bold">
                    {{ $enemyPlayer->user->name }}
                </h2>

                <p class="text-gray-400 text-sm uppercase tracking-widest">
                    {{ $enemyPlayer->gameClass->name }}
                </p>
            </div>

            <!-- gifs -->
            <div class="relative">
                <img src="{{ asset('gifs/' . $enemyClass . '.gif') }}" alt="{{ $enemyPlayer->gameClass->name }}"
                    class="w-56 h-56 object-contain scale-x-[-1] drop-shadow-[0_0_35px_rgba(255,0,0,0.15)]">

                @if($enemyPlayer->is_defending)
                    <div class="absolute inset-0 border-4 border-red-400 rounded-full animate-pulse"></div>
                @endif
            </div>

            <!-- hp -->
            <div class="w-full max-w-xs mt-6">
                <div class="flex justify-between text-sm text-gray-300 mb-2">
                    <span>HP</span>
                    <span>
                        {{ $enemyPlayer->current_hp }}
                        /
                        {{ $enemyPlayer->gameClass->base_hp }}
                    </span>
                </div>

                <div class="h-4 bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-full bg-red-500 transition-all duration-500" style="width: {{ $enemyHpPct }}%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>