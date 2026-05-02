<x-admin-layout title="Clients — Edit">
    <p class="mb-4"><a href="{{ route('admin.clients.index') }}" class="text-sm text-orange-300 hover:underline">&larr; Back to Clients</a></p>
    @include('admin.clients._form', [
        'client' => $client,
        'action' => route('admin.clients.update', $client),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
</x-admin-layout>
