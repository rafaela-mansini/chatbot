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
                'success' => false
            ];
        }
        else{
            $messages = [];
            $allMessages = explode('|', $message->bot_response);
            foreach($allMessages as $setMessage){
                array_push($messages, trans('messages.'.$setMessage));
            }

            $data = [
                'messages' => $messages,
                'code' => $message->bot_code,
                'success' => true
            ];
        }

        return response()->json($data);
    }
}
