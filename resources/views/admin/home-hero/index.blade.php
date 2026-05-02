<x-admin-layout title="Home hero slider">
    <div class="space-y-8">
        <section class="bg-slate-900 panel p-5">
            <h3 class="heading-text text-lg mb-3">Aspect ratio (slideshow)</h3>
            <p class="text-sm text-slate-400 mb-4 max-w-3xl">
                The hero fills the full content width. Each slide’s background uses <strong class="text-slate-200">cover</strong> cropping.
                Set the <strong class="text-slate-200">width : height</strong> ratio of the visible hero area (for example <code class="text-orange-300">16</code> and <code class="text-orange-300">9</code> for widescreen, or <code class="text-orange-300">1920</code> and <code class="text-orange-300">850</code> to mirror the original theme proportions).
                For sharp images on large screens, upload backgrounds at least <strong class="text-slate-200">1920px</strong> on the long edge.
            </p>
            <form method="POST" action="{{ route('admin.home-hero.settings.update') }}" class="flex flex-wrap items-end gap-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block mb-1 text-xs text-slate-400">Ratio width</label>
                    <input type="number" name="aspect_ratio_width" min="1" max="9999" required
                           value="{{ old('aspect_ratio_width', $settings->aspect_ratio_width) }}"
                           class="w-28">
                </div>
                <span class="text-slate-500 pb-2">:</span>
                <div>
                    <label class="block mb-1 text-xs text-slate-400">Ratio height</label>
                    <input type="number" name="aspect_ratio_height" min="1" max="9999" required
                           value="{{ old('aspect_ratio_height', $settings->aspect_ratio_height) }}"
                           class="w-28">
                </div>
                <button type="submit" class="btn btn-primary">Save ratio</button>
                <p class="text-xs text-slate-500 w-full basis-full">
                    Current label: <strong class="text-slate-300">{{ $settings->aspectRatioLabel() }}</strong>
                    — example pixel size at 1920px width:
                    <strong class="text-slate-300">1920 × {{ (int) round(1920 * $settings->aspect_ratio_height / max(1, $settings->aspect_ratio_width)) }} px</strong>
                </p>
            </form>
        </section>

        <section class="bg-slate-900 panel p-5">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <h3 class="heading-text text-lg">Slides</h3>
                <a href="{{ route('admin.home-hero.slides.create') }}" class="btn btn-primary">Add slide</a>
            </div>
            @if($slides->isEmpty())
                <p class="text-slate-400 text-sm">No slides yet — the site shows the default three static banners until you add at least one active slide.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-700 text-slate-400">
                                <th class="py-2 pr-3">Order</th>
                                <th class="py-2 pr-3">Title</th>
                                <th class="py-2 pr-3">Variant</th>
                                <th class="py-2 pr-3">Active</th>
                                <th class="py-2 pr-3">Image</th>
                                <th class="py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($slides as $slide)
                                <tr class="border-b border-slate-800">
                                    <td class="py-2 pr-3">{{ $slide->sort_order }}</td>
                                    <td class="py-2 pr-3 max-w-xs truncate">{{ \Illuminate\Support\Str::limit(strip_tags(str_replace(["\r", "\n"], ' ', (string) $slide->title)), 48) }}</td>
                                    <td class="py-2 pr-3">{{ $slide->style_variant }}</td>
                                    <td class="py-2 pr-3">{{ $slide->is_active ? 'Yes' : 'No' }}</td>
                                    <td class="py-2 pr-3">
                                        @if($slide->background_image_url)
                                            <a href="{{ $slide->background_image_url }}" target="_blank" rel="noopener" class="text-orange-300 hover:underline">Main</a>
                                        @else
                                            —
                                        @endif
                                        @if($slide->small_device_background_image_url)
                                            <span class="text-slate-600 mx-1">·</span>
                                            <a href="{{ $slide->small_device_background_image_url }}" target="_blank" rel="noopener" class="text-orange-300 hover:underline">Small</a>
                                        @endif
                                    </td>
                                    <td class="py-2 text-right whitespace-nowrap">
                                        <a href="{{ route('admin.home-hero.slides.edit', $slide) }}" class="text-orange-300 hover:underline mr-3">Edit</a>
                                        <form method="POST" action="{{ route('admin.home-hero.slides.destroy', $slide) }}" class="inline" onsubmit="return confirm('Delete this slide?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-400 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
</x-admin-layout>
