<x-admin-layout title="Lead Form Submissions">
    <div class="overflow-x-auto bg-slate-900 panel">
        <table class="w-full text-sm data-table">
            <thead class="bg-slate-800">
                <tr>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Source</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Phone</th>
                    <th class="p-3 text-left">Subject</th>
                    <th class="p-3 text-left">Message</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($submissions as $submission)
                <tr class="border-t border-slate-800">
                    <td class="p-3">{{ $submission->full_name }}</td>
                    <td class="p-3">{{ ucfirst($submission->source) }}</td>
                    <td class="p-3">{{ $submission->email }}</td>
                    <td class="p-3">{{ $submission->phone ?: '-' }}</td>
                    <td class="p-3">{{ $submission->subject ?: '-' }}</td>
                    <td class="p-3">{{ \Illuminate\Support\Str::limit((string) $submission->message, 120) ?: '-' }}</td>
                    <td class="p-3">{{ $submission->created_at?->format('d M Y h:i A') }}</td>
                    <td class="p-3 text-center">
                        <form method="POST" action="{{ route('admin.lead-submissions.destroy', $submission) }}" class="inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-secondary">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>

