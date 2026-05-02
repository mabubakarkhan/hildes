<x-admin-layout title="Clients — Bulk Background Colors">
    <div class="mb-4 flex flex-wrap gap-2 items-center justify-between">
        <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary inline-block">&larr; Back to Clients</a>
        <p class="text-sm text-slate-400">Default recommended color: <code>#FFFFFF</code></p>
    </div>

    <form method="POST" action="{{ route('admin.clients.bulk-colors.update') }}" class="bg-slate-900 panel p-4 md:p-5">
        @csrf
        @method('PUT')

        <div class="space-y-3">
            @forelse($clients as $client)
                <div class="border border-slate-800 rounded-lg p-3 bg-slate-800/40 flex items-center gap-3">
                    <img src="{{ $client->logo_url }}" alt="Client logo" class="h-12 w-auto rounded p-1 border border-slate-700" style="background: {{ $client->background_color ?: '#FFFFFF' }};">
                    <div class="ml-auto flex items-center gap-3">
                        <input type="color"
                               name="background_colors[{{ $client->id }}]"
                               value="{{ old('background_colors.'.$client->id, $client->background_color ?: '#FFFFFF') }}"
                               style="height: 44px; width: 56px; border-radius: 8px; border: 1px solid rgba(148,163,184,.35); padding: 4px;">
                        <span class="text-xs text-slate-400">{{ old('background_colors.'.$client->id, $client->background_color ?: '#FFFFFF') }}</span>
                    </div>
                </div>
            @empty
                <p class="text-slate-400 text-sm">No clients found.</p>
            @endforelse
        </div>

        <div class="mt-5">
            <button type="submit" class="btn btn-primary">Save All Colors</button>
        </div>
    </form>
</x-admin-layout>
