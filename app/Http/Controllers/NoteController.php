<?php

namespace App\Http\Controllers;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
  // the index() method is used to return all the notes
    public function index()
    {
        $notes = Note::all();
        return response()->json($notes);
    }
    
  // the store() method is used to create a new note
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $note = Note::create($validatedData);
        return response()->json($note, 201);
    }

  // the show() method is used to return a single note
    public function show(Note $note)
    {
        return response()->json($note);
    }

  // the update() method is used to update a note
    public function update(Request $request, Note $note)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $note->update($validatedData);
        return response()->json($note);
    }

  // the destroy() method is used to delete a note
    public function destroy(Note $note)
    {
        $note->delete();
        return response()->json(['message' => 'Note deleted successfully']);
    }


    
}
