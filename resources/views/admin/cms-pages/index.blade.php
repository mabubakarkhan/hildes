<x-admin-layout title="CMS Pages">
    <div class="mb-4 flex flex-wrap gap-2">
        <a href="{{ route('admin.cms-pages.create') }}" class="btn btn-primary inline-block">Add CMS page</a>
    </div>

    <div class="overflow-x-auto bg-slate-900 panel">
        <table class="w-full text-sm data-table">
            <thead class="bg-slate-800">
                <tr>
                    <th class="p-3 text-left">Title</th>
                    <th class="p-3 text-left">Slug</th>
                    <th class="p-3 text-center">FAQ Schema Ver.</th>
                    <th class="p-3 text-center">Published</th>
                    <th class="p-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($pages as $page)
                <tr class="border-t border-slate-800">
                    <td class="p-3">{{ $page->title }}</td>
                    <td class="p-3 font-mono text-xs">{{ $page->slug }}</td>
                    <td class="p-3 text-center">{{ $page->faq_schema_version }}</td>
                    <td class="p-3 text-center">{{ $page->is_published ? 'Yes' : 'No' }}</td>
                    <td class="p-3 text-center whitespace-nowrap">
                        <a href="{{ route('admin.cms-pages.edit', $page) }}" class="btn btn-secondary">Edit</a>
                        <form method="POST" action="{{ route('admin.cms-pages.destroy', $page) }}" class="inline" onsubmit="return confirm('Delete this CMS page?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary ml-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr class="border-t border-slate-800">
                    <td colspan="5" class="p-6 text-center text-slate-400">No CMS pages yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
