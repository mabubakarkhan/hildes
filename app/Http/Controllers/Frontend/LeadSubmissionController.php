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
            'source' => ['required', Rule::in(['contact', 'quote', 'consultation', 'career_resume'])],
            'full_name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:100'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:10000'],
            'resume_file' => ['nullable', 'file', 'max:5120', 'mimes:pdf,doc,docx'],
        ]);

        if ($request->input('source') === 'career_resume') {
            $request->validate([
                'resume_file' => ['required', 'file', 'max:5120', 'mimes:pdf,doc,docx'],
            ]);
        }

        if ($request->hasFile('resume_file')) {
            $data['resume_file'] = $request->file('resume_file')->store('lead-submissions/resume', 'public');
        }

        LeadSubmission::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Thanks! Your request has been received.',
        ]);
    }
}

