<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Transaction;

class TransactionsController extends Controller
{
    public function balance(){
        $balance = auth()->user()->balance;

        try {
            $transaction = Transaction::create([
                'method' => 'balance',
                'current_balance' => $balance,
                'user_id' => auth()->user()->id
            ]);
            return response()->json([ 'success' => true, 'balance' => $balance, 'transaction' => $transaction ]);

        } catch (\Throwable $th) {
            return response()->json([ 'success' => false, 'message' => $th->getMessage() ]);
        }
        
    }

    public function store(Request $request){
        dd($request->all());
        if($request->method == 'balance'){
            $request->validate([
                'balance' => 'required'
            ]);
            // just information about the balance

        }
        else{
            // inform currency and value to transaction
        }
    }
}
