<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">

        <h1 class="text-4xl font-bold mb-8">
            Dungeon Duel
        </h1>

        <div class="grid grid-cols-2 gap-8">

            <div class="bg-white p-6 rounded-xl shadow">

                <h2 class="text-2xl font-bold mb-4">
                    Enemy
                </h2>

                <div class="h-4 bg-red-200 rounded-full overflow-hidden">
                    <div class="bg-red-600 h-full w-3/4"></div>
                </div>

            </div>

            <div class="bg-white p-6 rounded-xl shadow">

                <h2 class="text-2xl font-bold mb-4">
                    You
                </h2>

                <div class="h-4 bg-green-200 rounded-full overflow-hidden">
                    <div class="bg-green-600 h-full w-full"></div>
                </div>

            </div>

        </div>

        <div class="mt-10 flex gap-4">

            <form method="POST" action="{{ route('battle.attack', $game) }}">
                @csrf

                <button class="bg-red-600 text-white px-6 py-3 rounded-xl">
                    Attack
                </button>

            </form>

            <form method="POST" action="{{ route('battle.defend', $game) }}">
                @csrf

                <button class="bg-blue-600 text-white px-6 py-3 rounded-xl">
                    Defend
                </button>

            </form>

        </div>

    </div>

</x-app-layout>