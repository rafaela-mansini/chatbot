<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Message;

class MessagesController extends Controller
{
    public function show(Request $request){
        $text = '';
        $message = Message::where('expected_entries', 'like', "%$request->expected_entries%")->first();
        if($message){
            $text = trans('messages.deposit');
        }
        else{
            $text = trans('messages.unknown');
        }

        return response()->json(['messsage' => $text]);
    }
}
