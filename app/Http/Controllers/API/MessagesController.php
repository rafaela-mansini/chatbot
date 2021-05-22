<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Message;

class MessagesController extends Controller
{
    public function show(Request $request){
        
        $message = Message::where('expected_entries', 'like', "%$request->expected_entries%")->first();
        if($message){
            $messages = [
                'deposit' => trans('messages.deposit'),
                'currency' => trans('messages.currency')
            ];
            $success = true;
        }
        else{
            $messages = [
                'message' => trans('messages.unknown')
            ];
            $success = false;
        }

        return response()->json(['messsages' => $messages, 'success' => $success]);
    }
}
