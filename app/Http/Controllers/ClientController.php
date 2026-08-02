<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required|string|max:20',
            'message' => 'required|string',

        ]);

        $client = Client::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'message' => $request->message,

        ]);

        // Envoi du mail à l'administrateur
        try {
            Mail::to('herinainan@gmail.com')
                ->send(new ContactMail($client));
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Message enregistré mais email non envoyé.'
            ], 500);
        }


        return response()->json([
            'success' => true,
            'message' => 'Votre message a été envoyé.',
            'data' => $client
        ], 201);
    }
}
