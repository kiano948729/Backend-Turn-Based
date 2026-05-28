@if(session('battle_result'))
<div class="bg-blue-50 border border-blue-300 text-blue-800 rounded-lg px-4 py-3 text-sm">
    battle {{ session('battle_result') }}
</div>
@endif

@if(session('success'))
<div class="bg-green-50 border border-green-300 text-green-800 rounded-lg px-4 py-3 text-sm">
    goed {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border border-red-300 text-red-800 rounded-lg px-4 py-3 text-sm">
    foit {{ session('error') }}
</div>
@endif