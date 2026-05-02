<x-admin-layout title="Testimonials">
    <div class="space-y-6">
        <div class="flex flex-wrap gap-3 justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold">Manage Testimonials</h3>
                <p class="text-sm text-slate-400">Homepage section now loads from this list.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.testimonials.order') }}" class="btn-secondary">Set Order</a>
                <a href="{{ route('admin.testimonials.create') }}" class="btn-primary">Add Testimonial</a>
            </div>
        </div>

        <div class="rounded-2xl border border-white/10 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-white/5">
                    <tr>
                        <th class="text-left p-3">Image</th>
                        <th class="text-left p-3">Name</th>
                        <th class="text-left p-3">Company / Designation</th>
                        <th class="text-left p-3">Order</th>
                        <th class="text-left p-3">Status</th>
                        <th class="text-right p-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $item)
                        <tr class="border-t border-white/10">
                            <td class="p-3">
                                @if($item->image_url)
                                    <img src="{{ $item->image_url }}" alt="{{ $item->image_alt ?: $item->name }}"
                                        class="h-12 rounded-md border border-white/10 bg-white/5 p-1">
                                @endif
                            </td>
                            <td class="p-3">{{ $item->name ?: '-' }}</td>
                            <td class="p-3">
                                <div>{{ $item->company ?: '-' }}</div>
                                <div class="text-xs text-slate-400">{{ $item->designation ?: '-' }}</div>
                            </td>
                            <td class="p-3">{{ $item->display_order }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-xs {{ $item->is_active ? 'bg-emerald-500/20 text-emerald-300' : 'bg-slate-500/20 text-slate-300' }}">
                                    {{ $item->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="p-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.testimonials.edit', $item) }}" class="btn-secondary">Edit</a>
                                    <form method="POST" action="{{ route('admin.testimonials.destroy', $item) }}"
                                        onsubmit="return confirm('Delete this testimonial?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-400">No testimonials yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
