<?php

namespace App\Http\Controllers;

use App\Models\Whatsapp;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function index()
    {
        $messages = Whatsapp::all();
        return $messages->toArray();
    }

    public function deletMessage($id)
    {
        Whatsapp::find($id)->delete();

        return response()->json(['message'=>'Message deleted successfully!']);
    }
}
