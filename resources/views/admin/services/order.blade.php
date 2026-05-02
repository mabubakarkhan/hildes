<x-admin-layout title="Services Order">
    <div class="mb-4 flex flex-wrap gap-2 items-center justify-between">
        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary inline-block">&larr; Back to Services</a>
        <p class="text-sm text-slate-400">Drag and drop to reorder, then save.</p>
    </div>

    <form method="POST" action="{{ route('admin.services.order.update') }}" id="services-order-form" class="bg-slate-900 panel p-4 md:p-5">
        @csrf
        @method('PUT')
        <input type="hidden" name="order" id="services-order-input" value="">

        <ul id="services-order-list" class="space-y-2">
            @foreach($services as $service)
                <li class="service-order-item border border-slate-800 rounded-lg p-3 bg-slate-800/40 flex items-center gap-3" draggable="true" data-id="{{ $service->id }}">
                    <span class="cursor-grab text-orange-300 select-none" title="Drag to reorder">&#x2630;</span>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold truncate">{{ $service->name }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ $service->slug }}</p>
                    </div>
                    <div class="flex gap-1 shrink-0">
                        <button type="button" class="btn btn-secondary order-up" title="Move up">&#8593;</button>
                        <button type="button" class="btn btn-secondary order-down" title="Move down">&#8595;</button>
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="mt-5">
            <button type="submit" class="btn btn-primary">Save Order</button>
        </div>
    </form>

    <script>
    (function () {
        const list = document.getElementById('services-order-list');
        const input = document.getElementById('services-order-input');
        const form = document.getElementById('services-order-form');
        if (!list || !input || !form) return;

        let dragging = null;

        const syncOrderInput = () => {
            const ids = Array.from(list.querySelectorAll('.service-order-item')).map((el) => Number(el.dataset.id));
            input.value = JSON.stringify(ids);
        };

        const moveItem = (item, direction) => {
            if (!item) return;
            if (direction < 0 && item.previousElementSibling) {
                item.parentNode.insertBefore(item, item.previousElementSibling);
            } else if (direction > 0 && item.nextElementSibling) {
                item.parentNode.insertBefore(item.nextElementSibling, item);
            }
            syncOrderInput();
        };

        list.querySelectorAll('.service-order-item').forEach((item) => {
            item.addEventListener('dragstart', () => {
                dragging = item;
                item.classList.add('opacity-60');
            });
            item.addEventListener('dragend', () => {
                item.classList.remove('opacity-60');
                dragging = null;
                syncOrderInput();
            });
            item.addEventListener('dragover', (event) => {
                event.preventDefault();
                if (!dragging || dragging === item) return;
                const rect = item.getBoundingClientRect();
                const after = event.clientY > rect.top + rect.height / 2;
                if (after) {
                    item.parentNode.insertBefore(dragging, item.nextSibling);
                } else {
                    item.parentNode.insertBefore(dragging, item);
                }
            });
        });

        list.addEventListener('click', (event) => {
            const btn = event.target.closest('button');
            if (!btn) return;
            const item = btn.closest('.service-order-item');
            if (!item) return;
            if (btn.classList.contains('order-up')) moveItem(item, -1);
            if (btn.classList.contains('order-down')) moveItem(item, 1);
        });

        form.addEventListener('submit', () => {
            syncOrderInput();
            const parsed = JSON.parse(input.value || '[]');
            input.removeAttribute('name');
            parsed.forEach((id) => {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'order[]';
                hidden.value = id;
                form.appendChild(hidden);
            });
        });

        syncOrderInput();
    })();
    </script>
</x-admin-layout>
