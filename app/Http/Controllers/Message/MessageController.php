<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);

        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $message = $request->input('message');

        try {
            $message = Message::create([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'phone' => $phone,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'envoi du message',
                'error' => $e->getMessage(),
            ], 500);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Votre message a bien été envoyé',
            'entity' => $message,
        ]);
    }

    public function getMessages()
    {
        $messages = Message::whereNull('archived_at')->get();

        return response()->json([
            'success' => true,
            'message' => 'Liste des messages',
            'entity' => $messages,
        ]);
    }
    
    public function getArchivedMessages()
    {
        $messages = Message::whereNotNull('archived_at')->get();

        return response()->json([
            'success' => true,
            'message' => 'Liste des messages archivés',
            'entity' => $messages,
        ]);
    }

    public function read(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $id = $request->input('id');

        $message = Message::find($id);
        $message->read_at = now();
        $message->save();

        return response()->json([
            'success' => true,
            'message' => 'Message lu',
            'entity' => $message,
        ]);
    }

    public function archive(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $id = $request->input('id');

        $message = Message::find($id);
        $message->archived_at = now();
        $message->save();

        return response()->json([
            'success' => true,
            'message' => 'Message archivé',
            'entity' => $message,
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $id = $request->input('id');

        $message = Message::find($id);
        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message supprimé',
            'entity' => $message,
        ]);
    }
}
