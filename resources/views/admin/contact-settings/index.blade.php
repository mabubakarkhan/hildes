<x-admin-layout title="Contact Settings">
    <form method="POST" action="{{ route('admin.contact-settings.update', $setting) }}" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-4 bg-slate-900 p-6 panel">
        @csrf
        @method('PUT')
        <input name="phone" value="{{ old('phone', $setting->phone) }}" placeholder="Phone">
        <input name="whatsapp" value="{{ old('whatsapp', $setting->whatsapp) }}" placeholder="WhatsApp">
        <input name="email" value="{{ old('email', $setting->email) }}" placeholder="Email">
        <input name="address_line" value="{{ old('address_line', $setting->address_line) }}" placeholder="Address">
        <input name="facebook" value="{{ old('facebook', $setting->facebook) }}" placeholder="Facebook URL">
        <input name="linkedin" value="{{ old('linkedin', $setting->linkedin) }}" placeholder="LinkedIn URL">
        <input name="github" value="{{ old('github', $setting->github) }}" placeholder="GitHub or Git repository URL">
        <input name="google_map_url" value="{{ old('google_map_url', $setting->google_map_url) }}" placeholder="Google Map URL">
        <div>
            <label class="block mb-1 text-sm">Header Logo</label>
            <input type="file" name="header_logo" class="w-full text-sm">
        </div>
        <div>
            <label class="block mb-1 text-sm">Footer Logo</label>
            <input type="file" name="footer_logo" class="w-full text-sm">
        </div>
        <textarea name="google_map_embed" placeholder="Google Map Embed code" class="md:col-span-2">{{ old('google_map_embed', $setting->google_map_embed) }}</textarea>
        <textarea name="extra_notes" placeholder="Extra contact notes" class="md:col-span-2">{{ old('extra_notes', $setting->extra_notes) }}</textarea>
        <button class="md:col-span-2 btn btn-primary form-submit">Update Contact Settings</button>
    </form>
</x-admin-layout>
