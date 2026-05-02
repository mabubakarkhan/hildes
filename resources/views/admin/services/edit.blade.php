<x-admin-layout title="Services — Edit: {{ $service->name }}">
    <p class="mb-4"><a href="{{ route('admin.services.index') }}" class="text-sm text-orange-300 hover:underline">&larr; Back to Services</a></p>
    @include('admin.services._form', [
        'service' => $service,
        'action' => route('admin.services.update', $service),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
</x-admin-layout>
