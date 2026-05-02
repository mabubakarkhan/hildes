<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;

class NewsletterSubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = NewsletterSubscription::query()->latest()->get();

        return view('admin.newsletter-subscriptions.index', compact('subscriptions'));
    }

    public function destroy(NewsletterSubscription $newsletterSubscription)
    {
        $newsletterSubscription->delete();

        return back()->with('success', 'Newsletter subscription removed.');
    }
}

