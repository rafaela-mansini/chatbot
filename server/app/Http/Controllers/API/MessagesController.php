<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Message;

class MessagesController extends Controller
{
    public function show(Request $request){
        $data = [];
        $message = Message::where('expected_entries', 'like', "%$request->expected_entries%")->first();

        if(!isset($request->expected_entries) || !isset($message)){
            $data = [
                'message'=> trans('messages.unknown'),
                'code' => 'unknown',
                'success' => false
            ];
        }
        else{

            $data = [
                'message' => trans('messages.'.$message->bot_response),
                'code' => $message->bot_code,
                'bot_response' => $message->bot_response,
                'next_step' => $message->next_step,
                'success' => true
            ];
        }

        return response()->json($data);
    }
}
