<x-admin-layout title="Services">
    <div class="mb-4 flex flex-wrap gap-2">
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary inline-block">Add service page</a>
        <a href="{{ route('admin.services.order') }}" class="btn btn-secondary inline-block">Set display order</a>
    </div>
    <div class="overflow-x-auto bg-slate-900 panel">
        <table class="w-full text-sm data-table">
            <thead class="bg-slate-800">
                <tr>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Slug</th>
                    <th class="p-3 text-center">Published</th>
                    <th class="p-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($services as $service)
                <tr class="border-t border-slate-800">
                    <td class="p-3">{{ $service->name }}</td>
                    <td class="p-3 font-mono text-xs">{{ $service->slug }}</td>
                    <td class="p-3 text-center">{{ $service->is_published ? 'Yes' : 'No' }}</td>
                    <td class="p-3 text-center whitespace-nowrap">
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-secondary">Edit</a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="inline" onsubmit="return confirm('Delete this service page?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-secondary ml-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr class="border-t border-slate-800">
                    <td colspan="4" class="p-6 text-center text-slate-400">No service pages yet. Add one to start.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
