<x-admin-layout title="Edit Testimonial">
    <div class="max-w-4xl">
        <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data"
            class="rounded-2xl border border-white/10 p-6 space-y-6">
            @csrf
            @method('PUT')
            @include('admin.testimonials._form')
            <div class="flex gap-2">
                <button class="btn-primary">Update Testimonial</button>
                <a href="{{ route('admin.testimonials.index') }}" class="btn-secondary">Back</a>
            </div>
        </form>
    </div>
</x-admin-layout>
