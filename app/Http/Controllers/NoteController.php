<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
class NoteController extends Controller
{
    public function allNotes(){
        $notes = Note::orderBy('id', 'DESC')->get();
        return $notes->toArray();
    }

    public function saveNote(Request $request){
        $request->validate([
            'title' => 'required',
        ]);

        if($request->id){
            $note = Note::find($request->id);
        }else{
            $note = new Note();
        }
        $note->title = $request->title;
        $note->description = $request->description;
        $note->label = $request->label;
        $note->save();

        return response()->json(['message' => 'Note saved successfully']);
    }

    public function deleteNote($id){
        Note::find($id)->delete();
        return response()->json(['message' => 'Note deleted successfully']);
    }

    public function deleteMultiple(Request $request){
        foreach ($request->all() as $note) {
            Note::find($note)->delete();
        }

        return response()->json(['message' => 'Notes deleted successfully']);
    }
}
