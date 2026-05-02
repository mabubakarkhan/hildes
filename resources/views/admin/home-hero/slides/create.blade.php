<x-admin-layout title="Home hero — New slide">
    <p class="mb-4"><a href="{{ route('admin.home-hero.index') }}" class="text-sm text-orange-300 hover:underline">&larr; Back to Home hero</a></p>
    @include('admin.home-hero.slides._form', [
        'slide' => null,
        'action' => route('admin.home-hero.slides.store'),
        'method' => 'POST',
        'submitLabel' => 'Create slide',
    ])
</x-admin-layout>
