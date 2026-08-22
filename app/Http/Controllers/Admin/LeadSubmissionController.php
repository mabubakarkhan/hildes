<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeadSubmission;
use Illuminate\Support\Facades\Storage;

class LeadSubmissionController extends Controller
{
    public function index()
    {
        $submissions = LeadSubmission::query()->latest()->get();

        return view('admin.lead-submissions.index', compact('submissions'));
    }

    public function destroy(LeadSubmission $leadSubmission)
    {
        if ($leadSubmission->resume_file) {
            Storage::disk('public')->delete($leadSubmission->resume_file);
        }

        $leadSubmission->delete();

        return back()->with('success', 'Lead submission removed.');
    }
}

