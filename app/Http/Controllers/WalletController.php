<?php

namespace App\Http\Controllers;


use App\Models\User;
use DB;

class WalletController extends Controller
{
    public function __invoke(\Illuminate\Http\Request $request)
    {
        $splited = explode('_',$request->key);

        $qty = $splited[1];

        $user = User::where('stripe_id', $splited[2]."_".$splited[3])->first();
        if ($user) {
            $wallet = $user->wallet;
            $wallet->balance = $qty;
            $wallet->save();

            return redirect()->route('home');
        }
    }
}
