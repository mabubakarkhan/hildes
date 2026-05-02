<x-admin-layout title="Clients">
    <div class="mb-4 flex flex-wrap gap-2">
        <a href="{{ route('admin.clients.create') }}" class="btn btn-primary inline-block">Add client</a>
        <a href="{{ route('admin.clients.order') }}" class="btn btn-secondary inline-block">Set display order</a>
        <a href="{{ route('admin.clients.bulk-colors') }}" class="btn btn-secondary inline-block">Bulk background colors</a>
        <a href="{{ route('admin.clients.bulk-upload') }}" class="btn btn-secondary inline-block">Bulk upload logos</a>
    </div>

    <div class="overflow-x-auto bg-slate-900 panel">
        <table class="w-full text-sm data-table">
            <thead class="bg-slate-800">
                <tr>
                    <th class="p-3 text-left">Logo</th>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Phone</th>
                    <th class="p-3 text-center">Active</th>
                    <th class="p-3 text-center">Order</th>
                    <th class="p-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                    <tr class="border-t border-slate-800">
                        <td class="p-3">
                            @if($client->logo_url)
                                <img src="{{ $client->logo_url }}" alt="{{ $client->name ?: 'Client logo' }}" class="h-10 w-auto rounded bg-white/80 p-1">
                            @else
                                —
                            @endif
                        </td>
                        <td class="p-3">{{ $client->name ?: '—' }}</td>
                        <td class="p-3">{{ $client->email ?: '—' }}</td>
                        <td class="p-3">{{ $client->phone ?: '—' }}</td>
                        <td class="p-3 text-center">{{ $client->is_active ? 'Yes' : 'No' }}</td>
                        <td class="p-3 text-center">{{ $client->display_order }}</td>
                        <td class="p-3 text-center whitespace-nowrap">
                            <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-secondary">Edit</a>
                            <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" class="inline" onsubmit="return confirm('Delete this client?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-secondary ml-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t border-slate-800">
                        <td colspan="7" class="p-6 text-center text-slate-400">No clients yet. Add one to show logo on homepage.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
