<x-admin-layout title="Clients — Bulk Upload Logos">
    <p class="mb-4"><a href="{{ route('admin.clients.index') }}" class="text-sm text-orange-300 hover:underline">&larr; Back to Clients</a></p>

    <form method="POST" action="{{ route('admin.clients.bulk-upload.store') }}" enctype="multipart/form-data" class="bg-slate-900 panel p-5 space-y-4 max-w-3xl">
        @csrf
        <div>
            <h3 class="heading-text text-lg mb-1">Bulk Upload Client Logos</h3>
            <p class="text-sm text-slate-400">Select multiple images. Only logos are required. Each uploaded image creates one client record.</p>
        </div>

        <div>
            <label class="block mb-1 text-sm">Client logos</label>
            <input type="file" name="logos[]" accept="image/*" multiple required>
            <p class="text-xs text-slate-500 mt-2">Supported image files, max 4MB each.</p>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn btn-primary">Upload Logos</button>
            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</x-admin-layout>
