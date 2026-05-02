<x-admin-layout title="Home hero — Edit slide">
    <p class="mb-4"><a href="{{ route('admin.home-hero.index') }}" class="text-sm text-orange-300 hover:underline">&larr; Back to Home hero</a></p>
    @include('admin.home-hero.slides._form', [
        'slide' => $slide,
        'action' => route('admin.home-hero.slides.update', $slide),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
</x-admin-layout>
