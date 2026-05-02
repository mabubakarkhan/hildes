<x-admin-layout title="Job Applications">
    <div class="mb-4">
        <a href="{{ route('admin.applications.create') }}" class="btn btn-primary inline-block">Add Application</a>
    </div>
    <div class="overflow-x-auto bg-slate-900 panel">
        <table class="w-full text-sm data-table">
            <thead class="bg-slate-800">
                <tr>
                    <th class="p-3 text-left">Candidate</th><th class="p-3 text-left">Job</th><th class="p-3">Status</th><th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($applications as $application)
                <tr class="border-t border-slate-800">
                    <td class="p-3">{{ $application->full_name }}</td>
                    <td class="p-3">{{ $application->job?->title }}</td>
                    <td class="p-3 text-center">{{ ucfirst($application->status) }}</td>
                    <td class="p-3 text-center">
                        <a href="{{ route('admin.applications.edit', $application) }}" class="btn btn-secondary">Edit</a>
                        <form method="POST" action="{{ route('admin.applications.destroy', $application) }}" class="inline">
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
