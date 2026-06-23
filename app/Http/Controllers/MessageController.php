<?php

namespace App\Http\Controllers;
use App\Models\Message;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function allmessages(){
        $messages = Message::where('product_id', '=', null)->orderBy('id', 'DESC')->get();

        return $this->cleanUtf8Response($messages->toArray());
    }

    public function messages(){
        $messages = Message::where('product_id', '!=', null)->with('product')->orderBy('id', 'DESC')->get();

        return $this->cleanUtf8Response($messages->toArray());
    }

    public function singleMessage($id){
        $message = Message::find($id);
        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }
        return $this->cleanUtf8Response($message->toArray());
    }

    public function deletMessage($id){
        Message::find($id)->delete();
        return response()->json(['message' => 'Message deleted successfully']);
    }
}
