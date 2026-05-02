<x-admin-layout title="Newsletter Subscriptions">
    <div class="overflow-x-auto bg-slate-900 panel">
        <table class="w-full text-sm data-table">
            <thead class="bg-slate-800">
                <tr>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($subscriptions as $subscription)
                <tr class="border-t border-slate-800">
                    <td class="p-3">{{ $subscription->email }}</td>
                    <td class="p-3">{{ ucfirst($subscription->status) }}</td>
                    <td class="p-3">{{ $subscription->created_at?->format('d M Y h:i A') }}</td>
                    <td class="p-3 text-center">
                        <form method="POST" action="{{ route('admin.newsletter-subscriptions.destroy', $subscription) }}" class="inline">
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

