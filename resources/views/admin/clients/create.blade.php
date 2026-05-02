<x-admin-layout title="Clients — New">
    <p class="mb-4"><a href="{{ route('admin.clients.index') }}" class="text-sm text-orange-300 hover:underline">&larr; Back to Clients</a></p>
    @include('admin.clients._form', [
        'client' => null,
        'action' => route('admin.clients.store'),
        'method' => 'POST',
        'submitLabel' => 'Create client',
    ])
</x-admin-layout>
