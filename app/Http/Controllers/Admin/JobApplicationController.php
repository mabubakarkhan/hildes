<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use App\Notifications\NewJobApplicationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class JobApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::with('job')->latest()->get();

        return view('admin.applications.index', compact('applications'));
    }

    public function create()
    {
        $jobs = Job::where('status', 'open')->orderBy('title')->get();

        return view('admin.applications.create', compact('jobs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'job_id' => ['required', 'exists:career_jobs,id'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:100'],
            'education_level' => ['nullable', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:60'],
            'skills' => ['nullable', 'string'],
            'cover_letter' => ['nullable', 'string'],
            'cv_file' => ['nullable', 'file', 'max:5120'],
        ]);

        if ($request->hasFile('cv_file')) {
            $data['cv_file'] = $request->file('cv_file')->store('applications/cv', 'public');
        }

        $application = JobApplication::create($data);

        User::where('is_admin', true)->get()->each(function (User $admin) use ($application) {
            $admin->notify(new NewJobApplicationNotification($application));
        });

        return redirect()->route('admin.applications.index')->with('success', 'Application added.');
    }

    public function edit(JobApplication $application)
    {
        $jobs = Job::orderBy('title')->get();

        return view('admin.applications.edit', compact('application', 'jobs'));
    }

    public function update(Request $request, JobApplication $application)
    {
        $data = $request->validate([
            'job_id' => ['required', 'exists:career_jobs,id'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:100'],
            'education_level' => ['nullable', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:60'],
            'skills' => ['nullable', 'string'],
            'cover_letter' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['new', 'accepted', 'rejected'])],
            'admin_notes' => ['nullable', 'string'],
            'cv_file' => ['nullable', 'file', 'max:5120'],
        ]);

        if ($request->hasFile('cv_file')) {
            if ($application->cv_file) {
                Storage::disk('public')->delete($application->cv_file);
            }
            $data['cv_file'] = $request->file('cv_file')->store('applications/cv', 'public');
        }

        if ($application->status !== $data['status']) {
            $data['reviewed_at'] = now();
        }

        $application->update($data);

        return redirect()->route('admin.applications.index')->with('success', 'Application updated.');
    }

    public function destroy(JobApplication $application)
    {
        if ($application->cv_file) {
            Storage::disk('public')->delete($application->cv_file);
        }

        $application->delete();

        return back()->with('success', 'Application removed.');
    }
}
