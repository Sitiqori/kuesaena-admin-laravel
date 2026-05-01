<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\UserCoin;
use App\Models\UserRewardRedemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CustomerRewardController extends Controller
{
    public function index()
    {
        $rewards   = Reward::where('is_active', true)->get();
        $userCoins = Auth::user()->total_coins;

        return view('customer.pages.reward.index', compact('rewards', 'userCoins'));
    }

    public function redeem(Request $request, $id)
    {
        $reward = Reward::where('is_active', true)->findOrFail($id);
        $user   = Auth::user();
        $coins  = $user->total_coins;

        if ($coins < $reward->cost_coins) {
            return redirect()->back()->with('error', 'Koin kamu tidak cukup untuk menukar reward ini.');
        }

        // Deduct coins
        $coinRecord = UserCoin::firstOrCreate(
            ['user_id' => $user->id],
            ['coins'   => 0]
        );
        $coinRecord->decrement('coins', $reward->cost_coins);

        // Create redemption
        UserRewardRedemption::create([
            'user_id'    => $user->id,
            'reward_id'  => $reward->id,
            'code'       => strtoupper(Str::random(8)),
            'status'     => 'active',
            'expires_at' => now()->addDays(30),
        ]);

        return redirect()->route('customer.reward')->with('success', "Reward \"{$reward->name}\" berhasil ditukar!");
    }
}
