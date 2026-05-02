@php($c = $client ?? null)

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="bg-slate-900 panel p-5 space-y-4 max-w-4xl">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 text-sm">Client name</label>
            <input name="name" value="{{ old('name', $c->name ?? '') }}" placeholder="Client name (optional)">
        </div>
        <div>
            <label class="block mb-1 text-sm">Phone</label>
            <input name="phone" value="{{ old('phone', $c->phone ?? '') }}" placeholder="Phone (optional)">
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 text-sm">Email</label>
            <input type="email" name="email" value="{{ old('email', $c->email ?? '') }}" placeholder="Email (optional)">
        </div>
        <div>
            <label class="block mb-1 text-sm">Website URL</label>
            <input type="url" name="website_url" value="{{ old('website_url', $c->website_url ?? '') }}" placeholder="https://example.com (optional)">
        </div>
    </div>

    <div>
        <label class="block mb-1 text-sm">Address</label>
        <input name="address" value="{{ old('address', $c->address ?? '') }}" placeholder="Address (optional)">
    </div>

    <div>
        <label class="block mb-1 text-sm">Notes</label>
        <textarea name="notes" rows="4" placeholder="Any extra details (optional)">{{ old('notes', $c->notes ?? '') }}</textarea>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 text-sm">Display order</label>
            <input type="number" name="display_order" min="0" max="999999" value="{{ old('display_order', $c->display_order ?? 0) }}">
        </div>
        <div>
            <label class="block mb-1 text-sm">Logo background color</label>
            <input type="color" name="background_color" value="{{ old('background_color', $c->background_color ?? '#FFFFFF') }}" style="height: 48px;">
        </div>
        <div class="flex items-end">
            <label class="inline-flex items-center gap-2">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" @checked((string) old('is_active', ($c->is_active ?? true) ? '1' : '0') === '1')>
                <span class="text-sm">Active on homepage</span>
            </label>
        </div>
    </div>

    <div>
        <label class="block mb-1 text-sm">Client logo @if($c?->logo) (replace optional) @else (required) @endif</label>
        @if($c?->logo_url)
            <p class="text-xs text-slate-400 mb-2">Current: <a class="text-orange-300 underline" href="{{ $c->logo_url }}" target="_blank" rel="noopener">view</a>
                @if(filled($c->logo_original_name)) ({{ $c->logo_original_name }}) @endif
            </p>
        @endif
        <input type="file" name="logo" accept="image/*" @if(!$c?->logo) required @endif>
        <p class="text-xs text-slate-500 mt-2">Only logo is required. All other fields are optional.</p>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
        <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
