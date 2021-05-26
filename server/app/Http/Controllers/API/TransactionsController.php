<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Transaction;
use App\Http\Requests\TransactionRequest;
use App\Http\Services\TransactionService;

class TransactionsController extends Controller
{
    public function balance(){
        $balance = auth()->user()->balance;

        try {
            $service = new TransactionService();
            $service->balance();
            
            return response()->json([ 'success' => true, 'data' => $service->data ]);

        } catch (\Exception $th) {
            return response()->json([ 'success' => false, 'message' => $th->getMessage() ], 500);
        }
        
    }

    public function deposit(TransactionRequest $request){
        $validated = $request->validated();

        try {
            $currency = (isset($request->currency) && $request->currency !== 'no') ? $request->currency : env('DEFAULT_CURRENCY');
            $service = new TransactionService();
            $service->deposit($request->amount, $currency);
            
            return response()->json([ 'success' => true, 'data' => $service->data, 'message' => trans('messages.successDeposit') ]);

        } catch (\Throwable $th) {
            return response()->json([ 'success' => false, 'message' => $th->getMessage() ], 500);
        }
        
    }

    public function withdraw(TransactionRequest $request){
        $validated = $request->validated();

        try {
            $service = new TransactionService();
            $result = $service->withdraw($request->amount, $request->currency ?? env('DEFAULT_CURRENCY'));

            if(!$result){
                return response()->json([ 'success' => false, 'data' => $service->data ], 400);    
            }
            
            return response()->json([ 'success' => true, 'data' => $service->data ]);

        } catch (\Throwable $th) {
            return response()->json([ 'success' => false, 'message' => $th->getMessage() ], 500);
        }
        
    }
}
