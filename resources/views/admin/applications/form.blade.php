@csrf
<div class="grid md:grid-cols-2 gap-4 bg-slate-900 p-6 panel">
    <select name="job_id">
        @foreach($jobs as $jobItem)
            <option value="{{ $jobItem->id }}" @selected(old('job_id', $application->job_id ?? '') == $jobItem->id)>{{ $jobItem->title }}</option>
        @endforeach
    </select>
    <input name="full_name" required value="{{ old('full_name', $application->full_name ?? '') }}" placeholder="Candidate full name">
    <input name="email" required type="email" value="{{ old('email', $application->email ?? '') }}" placeholder="Candidate email">
    <input name="phone" value="{{ old('phone', $application->phone ?? '') }}" placeholder="Phone">
    <input name="education_level" value="{{ old('education_level', $application->education_level ?? '') }}" placeholder="Education level">
    <input name="experience_years" type="number" min="0" value="{{ old('experience_years', $application->experience_years ?? 0) }}" placeholder="Experience years">
    @isset($application)
    <div>
        <p class="text-sm mb-2">Application status</p>
        <div class="option-pills">
            @foreach(['new','accepted','rejected'] as $s)
                @php($asid = 'app_status_' . $s)
                <input id="{{ $asid }}" type="radio" name="status" value="{{ $s }}" @checked(old('status', $application->status) === $s)>
                <label for="{{ $asid }}">{{ ucfirst($s) }}</label>
            @endforeach
        </div>
    </div>
    @endisset
    <input name="cv_file" type="file">
    <textarea name="skills" placeholder="Skills" class="md:col-span-2">{{ old('skills', $application->skills ?? '') }}</textarea>
    <textarea name="cover_letter" placeholder="Cover letter" class="md:col-span-2">{{ old('cover_letter', $application->cover_letter ?? '') }}</textarea>
    @isset($application)
    <textarea name="admin_notes" placeholder="Admin notes" class="md:col-span-2">{{ old('admin_notes', $application->admin_notes) }}</textarea>
    @endisset
    <button class="md:col-span-2 btn btn-primary form-submit">Save Application</button>
</div>
