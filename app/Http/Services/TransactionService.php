<?php

namespace App\Http\Services;

use App\Transaction;
use App\Currency;
use App\User;
use App\Http\Services\Curl;

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

        $currency_exchange = $this->currency_exchange($currency, $amount);
        $currentBalance = $this->user->balance;
        $this->user->balance = $currentBalance + $currency_exchange;
        $this->user->save();

        $transaction = $this->storeTransaction('deposit', $currentBalance, $currency_exchange, $this->user->balance);

        $this->data = [
            'success' => true,
            'balance' => $this->user->balance,
        ];
        
    }

    public function withdraw(Float $amount, String $currency){

        $currency_exchange = $this->currency_exchange($currency, $amount);
        $currentBalance = $this->user->balance;

        if($currentBalance < $currency_exchange){
            $this->data = [
                'success' => false,
                'messages' => ['message' => trans('messages.notBalanceWithdraw')]
            ];
            return false;
        }

        $this->user->balance = $currentBalance - $currency_exchange;
        $this->user->save();

        $transaction = $this->storeTransaction('withdraw', $currentBalance, $currency_exchange, $this->user->balance);

        $this->data = [
            'success' => true,
            'balance' => $this->user->balance,
        ];

        return true;
    }

    public function currency_exchange($currency, $amount){
        $baseCurrency = $this->user->currency ?? env('DEFAULT_CURRENCY');

        if($currency == $baseCurrency){
            return $amount;
        }

        //validar se está em alguma listagem de currencys
        if(!$this->isValidCurrency($currency)){
            throw new \Exception(trans('messages.invalidCurrency'));
        }
        
        $endpoint = env('CURRENCY_API_ENDPOINT').'latest?access_key='.env('CURRENCY_API_KEY').'&base='.env('DEFAULT_CURRENCY').'&symbols='.$currency.','.$baseCurrency;
        $curl = new Curl($endpoint);
        $result = $curl->get();

        if(isset($result['error'])){
            throw new \Exception($result['error']['info']);
        }

        /**
         * This proccess will be necessary because in a free plan to API, we only can use EUR into a currency base.
         * Because this, the conversion to $currency information for Eur to know how much it is in Euro
         * and then convert into a $baseCurrency about user to save in transactions;
         */

        $currencyToBaseApi = $amount / $result['rates'][$currency];
        $currencyBaseToUserBase = $currencyToBaseApi * $result['rates'][$baseCurrency];
        // dd($currencyBaseToUserBase);

        return round($currencyBaseToUserBase, 2);
    }

    private function isValidCurrency($currency){
        $code = Currency::whereCurrency($currency)->first();

        return isset($code) ? true : false;
    }

    private function storeTransaction(String $method, Float $currentBalance, ?Float $transactionBalance, ?Float $newBalance){
        return Transaction::create([
            'method' => 'balance',
            'current_balance' => $currentBalance,
            'transaction_balance' => $transactionBalance,
            'new_balance' => $newBalance,
            'user_id' => $this->user->id,
            'currency' => $this->user->currency ?? env('DEFAULT_CURRENCY'),
        ]);
    }
}