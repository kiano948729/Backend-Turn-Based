<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function index()
    {
        $friends = Friend::where('user_id', Auth::id())
            ->orWhere('friend_user_id', Auth::id())
            ->with(['user', 'friendUser'])
            ->get();

        $accepted = $friends->where('status', 'accepted');

        $incoming = Friend::where('friend_user_id', Auth::id())
            ->where('status', 'pending')
            ->with('user')
            ->get();

        return view('friends.index', compact('accepted', 'incoming'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);

        $target = User::where('name', $request->search)
            ->orWhere('email', $request->search)
            ->where('id', '!=', Auth::id())
            ->first();

        if (!$target) {
            return back()->with('error', 'Gebruiker niet gevonden.');
        }

        $already = Friend::where(function ($q) use ($target) {
            $q->where('user_id', Auth::id())
                ->where('friend_user_id', $target->id);
        })->orWhere(function ($q) use ($target) {
            $q->where('user_id', $target->id)
                ->where('friend_user_id', Auth::id());
        })->exists();

        if ($already) {
            return back()->with('error', 'Uitnodiging bestaat al of jullie zijn al vrienden.');
        }

        Friend::create([
            'user_id' => Auth::id(),
            'friend_user_id' => $target->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Vriendverzoek verstuurd naar ' . $target->name . '!');
    }

    public function accept(Friend $friend)
    {
        if ($friend->friend_user_id !== Auth::id()) {
            return back()->with('error', 'Geen toegang.');
        }

        $friend->update(['status' => 'accepted']);

        return back()->with('success', 'Vriendverzoek geaccepteerd!');
    }

    public function decline(Friend $friend)
    {
        if ($friend->friend_user_id !== Auth::id()) {
            return back()->with('error', 'Geen toegang.');
        }

        $friend->update(['status' => 'declined']);

        return back()->with('success', 'Vriendverzoek geweigerd.');
    }
}
