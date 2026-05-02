<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeadSubmission;

class LeadSubmissionController extends Controller
{
    public function index()
    {
        $submissions = LeadSubmission::query()->latest()->get();

        return view('admin.lead-submissions.index', compact('submissions'));
    }

    public function destroy(LeadSubmission $leadSubmission)
    {
        $leadSubmission->delete();

        return back()->with('success', 'Lead submission removed.');
    }
}

