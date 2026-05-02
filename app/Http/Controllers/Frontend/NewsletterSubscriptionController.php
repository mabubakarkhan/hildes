<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;

class NewsletterSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        try {
            NewsletterSubscription::firstOrCreate(
                ['email' => strtolower($data['email'])],
                ['status' => 'active']
            );
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Thanks! You are subscribed successfully.',
        ]);
    }
}

