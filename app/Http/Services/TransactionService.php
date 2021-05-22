<?php

namespace App\Http\Services;

use App\Transaction;
use App\User;

class TransactionService {

    public $data;

    public function __construct(){
        $this->repository = app(Transaction::class);
    }

    public function deposit(Float $amount, String $currency){
        
        $user = auth()->user();
        $currentBalance = $user->balance;
        $user->balance = $currentBalance + $amount;
        $user->save();

        $transaction = $this->storeTransaction('deposit', $currentBalance, $amount, $user->balance, $user);

        $this->data = [
            'success' => true,
            'user' => $user,
            'transaction' => $transaction
        ];
        
    }

    private function storeTransaction(String $method, Float $currentBalance, Float $transactionBalance, Float $newBalance, User $user){
        return Transaction::create([
            'method' => 'balance',
            'current_balance' => $currentBalance,
            'transaction_balance' => $transactionBalance,
            'new_balance' => $newBalance,
            'user_id' => $user->id
        ]);
    }
}