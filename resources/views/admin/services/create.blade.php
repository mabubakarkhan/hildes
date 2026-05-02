<x-admin-layout title="Services — New page">
    <p class="mb-4"><a href="{{ route('admin.services.index') }}" class="text-sm text-orange-300 hover:underline">&larr; Back to Services</a></p>
    @include('admin.services._form', [
        'service' => null,
        'action' => route('admin.services.store'),
        'method' => 'POST',
        'submitLabel' => 'Create service page',
    ])
</x-admin-layout>
