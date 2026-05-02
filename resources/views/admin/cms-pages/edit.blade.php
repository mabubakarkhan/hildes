<x-admin-layout title="CMS Pages — Edit">
    <p class="mb-4"><a href="{{ route('admin.cms-pages.index') }}" class="text-sm text-orange-300 hover:underline">&larr; Back to CMS Pages</a></p>
    @include('admin.cms-pages._form', [
        'cmsPage' => $cmsPage,
        'action' => route('admin.cms-pages.update', $cmsPage),
        'method' => 'PUT',
        'submitLabel' => 'Update CMS page',
    ])
</x-admin-layout>
