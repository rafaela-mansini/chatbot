<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Transaction;

class UsersController extends Controller
{
    public function setCurrencyBase(Request $request){

        $request->validate([
            'currency' => 'required|exists:currencies,currency'
        ]);

        try {
            $user = auth()->user();
            $user->currency = $request->currency;
            $user->save();
            return response()->json([ 'success' => true, 'data' => ['user' => $user, 'message' => trans('messages.currencySave')] ]);
        } catch (\Throwable $th) {
            return response()->json([ 'success' => false, 'message' => $th->getMessage() ], 500);
        }
        
    }

    public function show(){
        $transactions = auth()->user()->transactions()->paginate(15);
        return response()->json([ 'success' => true, 'data' => $transactions ]);
    }
}
