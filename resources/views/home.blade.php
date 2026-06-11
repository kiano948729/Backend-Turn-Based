<x-app-layout>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            <div class="bg-[#111827] rounded-2xl p-8 text-center shadow-xl border border-gray-800">
                <h1 class="text-4xl font-bold text-white mb-3">Dungeon Duel</h1>
                <p class="text-gray-400 text-lg mb-6">
                    Kies je klasse, versla je tegenstander en klim naar de top.
                </p>
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                        Naar dashboard
                    </a>
                @else
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('login') }}"
                            class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                            Inloggen
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-gray-700 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                            Registreren
                        </a>
                    </div>
                @endauth
            </div>

            <div class="bg-[#111827] rounded-2xl p-6 shadow-xl border border-gray-800">
                <h2 class="text-white text-2xl font-bold mb-6">Leaderboard</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div>
                        <h3 class="text-yellow-400 font-semibold mb-3">Vandaag</h3>
                        @include('partials.leaderboard-list', ['leaders' => $dailyLeaders])
                    </div>

                    <div>
                        <h3 class="text-yellow-400 font-semibold mb-3">Deze week</h3>
                        @include('partials.leaderboard-list', ['leaders' => $weeklyLeaders])
                    </div>

                    <div>
                        <h3 class="text-yellow-400 font-semibold mb-3">All time</h3>
                        @include('partials.leaderboard-list', ['leaders' => $allTimeLeaders])
                    </div>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>