<x-admin-layout title="Careers / Jobs">
    <div class="mb-4">
        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary inline-block">Add New Job</a>
    </div>
    <div class="overflow-x-auto bg-slate-900 panel">
        <table class="w-full text-sm data-table">
            <thead class="bg-slate-800">
                <tr>
                    <th class="p-3 text-center w-14">Icon</th>
                    <th class="p-3 text-left">Title</th><th class="p-3 text-left">Department</th><th class="p-3">Status</th><th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($jobs as $job)
                <tr class="border-t border-slate-800">
                    <td class="p-3 text-center text-xl text-[#ff9b5c]">
                        <i class="{{ $job->icon_class ?: config('job_icon_picker.default') }}" aria-hidden="true"></i>
                    </td>
                    <td class="p-3">{{ $job->title }}</td>
                    <td class="p-3">{{ $job->department }}</td>
                    <td class="p-3 text-center">{{ ucfirst($job->status) }}</td>
                    <td class="p-3 text-center">
                        <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-secondary">Edit</a>
                        <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}" class="inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-secondary ml-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>
