<x-admin-layout title="Notifications">
    <div class="overflow-x-auto bg-slate-900 panel">
        <table class="w-full text-sm data-table">
            <thead class="bg-slate-800">
                <tr>
                    <th class="p-3 text-left">Title</th>
                    <th class="p-3 text-left">Candidate</th>
                    <th class="p-3 text-left">Job</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Date</th>
                </tr>
            </thead>
            <tbody>
            @forelse($notifications as $notification)
                <tr class="border-t border-slate-800">
                    <td class="p-3 font-semibold">{{ $notification->data['title'] ?? 'Notification' }}</td>
                    <td class="p-3">{{ $notification->data['candidate'] ?? '-' }}</td>
                    <td class="p-3">{{ $notification->data['job_title'] ?? '-' }}</td>
                    <td class="p-3">{{ ucfirst($notification->data['status'] ?? 'new') }}</td>
                    <td class="p-3">{{ $notification->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-4 text-slate-400">No notifications available.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
