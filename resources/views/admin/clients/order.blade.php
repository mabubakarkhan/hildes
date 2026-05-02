<x-admin-layout title="Clients Order">
    <div class="mb-4 flex flex-wrap gap-2 items-center justify-between">
        <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary inline-block">&larr; Back to Clients</a>
        <p class="text-sm text-slate-400">Drag and drop logos to set order.</p>
    </div>

    <form method="POST" action="{{ route('admin.clients.order.update') }}" id="clients-order-form" class="bg-slate-900 panel p-4 md:p-5">
        @csrf
        @method('PUT')
        <input type="hidden" name="order" id="clients-order-input" value="">

        <ul id="clients-order-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($clients as $client)
                <li class="client-order-item border border-slate-800 rounded-lg p-3 bg-slate-800/40 flex items-center gap-3" draggable="true" data-id="{{ $client->id }}">
                    <span class="cursor-grab text-orange-300 select-none shrink-0" title="Drag to reorder">&#x2630;</span>
                    <img src="{{ $client->logo_url }}" alt="Client logo" class="h-12 w-auto bg-white/90 rounded p-1">
                    <div class="ml-auto text-xs text-slate-300">
                        Order: <span class="order-index">0</span>
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
        const list = document.getElementById('clients-order-list');
        const input = document.getElementById('clients-order-input');
        const form = document.getElementById('clients-order-form');
        if (!list || !input || !form) return;

        let dragging = null;

        const syncOrderInput = () => {
            const ids = Array.from(list.querySelectorAll('.client-order-item')).map((el) => Number(el.dataset.id));
            input.value = JSON.stringify(ids);
            Array.from(list.querySelectorAll('.client-order-item')).forEach((el, idx) => {
                const n = el.querySelector('.order-index');
                if (n) n.textContent = String(idx + 1);
            });
        };

        list.querySelectorAll('.client-order-item').forEach((item) => {
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
