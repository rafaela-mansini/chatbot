<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Transaction;
use App\Http\Requests\DepositRequest;
use App\Http\Services\TransactionService;

class TransactionsController extends Controller
{
    public function balance(){
        $balance = auth()->user()->balance;

        try {
            $service = new TransactionService();
            $service->balance();
            
            return response()->json([ 'success' => true, 'data' => $service->data ]);

        } catch (\Throwable $th) {dd($th);
            return response()->json([ 'success' => false, 'message' => $th->getMessage() ], 500);
        }
        
    }

    public function deposit(DepositRequest $request){
        $validated = $request->validated();

        try {
            $service = new TransactionService();
            $service->deposit($request->amount, $request->currency);
            
            return response()->json([ 'success' => true, 'data' => $service->data ]);

        } catch (\Throwable $th) {
            return response()->json([ 'success' => false, 'message' => $th->getMessage() ], 500);
        }
        
    }

    public function withdraw(DepositRequest $request){
        $validated = $request->validated();

        try {
            $service = new TransactionService();
            $result = $service->withdraw($request->amount, $request->currency);

            if(!$result){
                return response()->json([ 'success' => false, 'data' => $service->data ], 400);    
            }
            
            return response()->json([ 'success' => true, 'data' => $service->data ]);

        } catch (\Throwable $th) {
            return response()->json([ 'success' => false, 'message' => $th->getMessage() ], 500);
        }
        
    }
}
