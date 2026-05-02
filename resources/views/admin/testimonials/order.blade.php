<x-admin-layout title="Testimonials Order">
    <div class="space-y-6">
        <div class="flex flex-wrap justify-between gap-3 items-center">
            <p class="text-sm text-slate-400">Drag items to reorder testimonial slides for homepage.</p>
            <a href="{{ route('admin.testimonials.index') }}" class="btn-secondary">Back to Testimonials</a>
        </div>

        <form method="POST" action="{{ route('admin.testimonials.order.update') }}" id="testimonial-order-form"
            class="space-y-5">
            @csrf
            @method('PUT')
            <div id="testimonial-sortable" class="space-y-3">
                @foreach($testimonials as $item)
                    <div class="testimonial-sort-item rounded-xl border border-white/10 bg-white/5 p-3 flex items-center gap-3"
                        draggable="true" data-id="{{ $item->id }}">
                        <span class="cursor-move text-slate-300">::</span>
                        @if($item->image_url)
                            <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="h-12 rounded-md border border-white/10 bg-white/5 p-1">
                        @endif
                        <div class="min-w-0">
                            <p class="font-medium">{{ $item->name ?: 'Untitled testimonial' }}</p>
                            <p class="text-xs text-slate-400">Current order: {{ $item->display_order }} · {{ $item->is_active ? 'Active' : 'Inactive' }}</p>
                        </div>
                        <input type="hidden" name="order[]" value="{{ $item->id }}">
                    </div>
                @endforeach
            </div>
            <button class="btn-primary">Save Order</button>
        </form>
    </div>

    <script>
        (() => {
            const list = document.getElementById('testimonial-sortable');
            if (!list) return;

            let dragged = null;

            list.querySelectorAll('.testimonial-sort-item').forEach((item) => {
                item.addEventListener('dragstart', () => {
                    dragged = item;
                    item.classList.add('opacity-60');
                });

                item.addEventListener('dragend', () => {
                    item.classList.remove('opacity-60');
                });

                item.addEventListener('dragover', (event) => {
                    event.preventDefault();
                });

                item.addEventListener('drop', (event) => {
                    event.preventDefault();
                    if (!dragged || dragged === item) return;

                    const rect = item.getBoundingClientRect();
                    const before = event.clientY < rect.top + rect.height / 2;
                    if (before) {
                        list.insertBefore(dragged, item);
                    } else {
                        list.insertBefore(dragged, item.nextSibling);
                    }
                });
            });
        })();
    </script>
</x-admin-layout>
