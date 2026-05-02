<x-admin-layout title="CMS Pages — New page">
    <p class="mb-4"><a href="{{ route('admin.cms-pages.index') }}" class="text-sm text-orange-300 hover:underline">&larr; Back to CMS Pages</a></p>
    @include('admin.cms-pages._form', [
        'cmsPage' => null,
        'action' => route('admin.cms-pages.store'),
        'method' => 'POST',
        'submitLabel' => 'Create CMS page',
    ])
</x-admin-layout>
