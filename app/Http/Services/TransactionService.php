<?php

namespace App\Http\Services;

use App\Transaction;
use App\User;

class TransactionService {

    public $data;
    public $user;

    public function __construct(){
        $this->user = auth()->user();
    }

    public function balance(){
        $currentBalance = $this->user->balance;
        $transaction = $this->storeTransaction('deposit', $currentBalance, null, null);

        $this->data = [
            'success' => true,
            'balance' => $this->user->balance,
        ];
    }

    public function deposit(Float $amount, String $currency){
        
        $currentBalance = $this->user->balance;
        $this->user->balance = $currentBalance + $amount;
        $this->user->save();

        $transaction = $this->storeTransaction('deposit', $currentBalance, $amount, $this->user->balance);

        $this->data = [
            'success' => true,
            'balance' => $this->user->balance,
        ];
        
    }

    public function withdraw(Float $amount, String $currency){

        $currentBalance = $this->user->balance;

        if($currentBalance < $amount){
            $this->data = [
                'success' => false,
                'messages' => ['message' => trans('messages.notBalanceWithdraw')]
            ];
            return false;
        }

        $this->user->balance = $currentBalance - $amount;
        $this->user->save();

        $transaction = $this->storeTransaction('withdraw', $currentBalance, $amount, $this->user->balance);

        $this->data = [
            'success' => true,
            'balance' => $this->user->balance,
        ];

        return true;
    }

    private function storeTransaction(String $method, Float $currentBalance, ?Float $transactionBalance, ?Float $newBalance){
        return Transaction::create([
            'method' => 'balance',
            'current_balance' => $currentBalance,
            'transaction_balance' => $transactionBalance,
            'new_balance' => $newBalance,
            'user_id' => $this->user->id
        ]);
    }
}