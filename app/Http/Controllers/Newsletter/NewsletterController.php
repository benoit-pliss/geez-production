<?php

namespace App\Http\Controllers\Newsletter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        $email = $request->input('email');

        if (Newsletter::class::where('email', $email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cet email est déjà inscrit à la newsletter.',
            ], 400);
        }

        $newsletter = Newsletter::class::create([
            'email' => $email,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Email inscrit à la newsletter',
            'entity' => $newsletter,
        ]);
    }
}
