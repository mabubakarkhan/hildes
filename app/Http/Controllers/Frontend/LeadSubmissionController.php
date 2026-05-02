<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LeadSubmission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeadSubmissionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'source' => ['required', Rule::in(['contact', 'quote', 'consultation'])],
            'full_name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:100'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:10000'],
        ]);

        LeadSubmission::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Thanks! Your request has been received.',
        ]);
    }
}

