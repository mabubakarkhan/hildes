<x-admin-layout title="SEO Settings">
    <form method="POST" action="{{ route('admin.seo-settings.update', $setting) }}" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-4 bg-slate-900 p-6 panel">
        @csrf
        @method('PUT')

        <div class="md:col-span-2">
            <h3 class="text-lg font-semibold text-cyan-400 mb-1">General SEO defaults</h3>
            <p class="text-sm text-slate-400 mb-2">Used when a page does not define its own meta tags.</p>
        </div>

        <input name="default_meta_title" value="{{ old('default_meta_title', $setting->default_meta_title) }}" placeholder="Default page title" class="md:col-span-2">
        <textarea name="default_meta_description" placeholder="Default meta description" class="md:col-span-2" rows="3">{{ old('default_meta_description', $setting->default_meta_description) }}</textarea>
        <input name="default_meta_keywords" value="{{ old('default_meta_keywords', $setting->default_meta_keywords) }}" placeholder="Default meta keywords" class="md:col-span-2">
        <input name="default_meta_author" value="{{ old('default_meta_author', $setting->default_meta_author) }}" placeholder="Default meta author">
        <input name="default_robots_directive" value="{{ old('default_robots_directive', $setting->default_robots_directive) }}" placeholder="Default robots (e.g. index,follow)">
        <input name="og_site_name" value="{{ old('og_site_name', $setting->og_site_name) }}" placeholder="Open Graph site name">
        <input name="default_og_type" value="{{ old('default_og_type', $setting->default_og_type) }}" placeholder="Default OG type (website, article)">
        <input name="twitter_card" value="{{ old('twitter_card', $setting->twitter_card) }}" placeholder="Twitter card type (summary_large_image)">

        <div class="md:col-span-2 border-t border-slate-700 pt-4 mt-2">
            <h3 class="text-lg font-semibold text-cyan-400 mb-1">Social share images</h3>
            <p class="text-sm text-slate-400 mb-3">Shown when links are shared on Facebook, LinkedIn, X/Twitter, WhatsApp, etc. Recommended size: 1200×630 px (JPG or PNG).</p>
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Default Open Graph image</label>
            @if($setting->defaultOgImageUrl())
                <img src="{{ $setting->defaultOgImageUrl() }}" alt="Current OG image" class="mb-2 max-h-32 rounded border border-slate-700">
                <label class="flex items-center gap-2 text-sm text-slate-400 mb-2">
                    <input type="checkbox" name="remove_default_og_image" value="1"> Remove current image
                </label>
            @endif
            <input type="file" name="default_og_image" accept="image/jpeg,image/png,image/webp" class="w-full text-sm">
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Default Twitter / X image (optional)</label>
            <p class="text-xs text-slate-500 mb-2">Leave empty to use the Open Graph image above.</p>
            @if($setting->defaultTwitterImageUrl())
                <img src="{{ $setting->defaultTwitterImageUrl() }}" alt="Current Twitter image" class="mb-2 max-h-32 rounded border border-slate-700">
                <label class="flex items-center gap-2 text-sm text-slate-400 mb-2">
                    <input type="checkbox" name="remove_default_twitter_image" value="1"> Remove current image
                </label>
            @endif
            <input type="file" name="default_twitter_image" accept="image/jpeg,image/png,image/webp" class="w-full text-sm">
        </div>

        <button class="md:col-span-2 btn btn-primary form-submit">Update SEO Settings</button>
    </form>
</x-admin-layout>
