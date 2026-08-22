<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeoSettingController extends Controller
{
    public function index()
    {
        $setting = SeoSetting::getSingleton();

        if ($setting->default_og_image) {
            SeoSetting::publishPublicFile($setting->default_og_image);
        }
        if ($setting->default_twitter_image) {
            SeoSetting::publishPublicFile($setting->default_twitter_image);
        }

        return view('admin.seo-settings.index', compact('setting'));
    }

    public function update(Request $request, SeoSetting $seo_setting)
    {
        $data = $request->validate([
            'default_meta_title' => ['nullable', 'string', 'max:255'],
            'default_meta_description' => ['nullable', 'string', 'max:1000'],
            'default_meta_keywords' => ['nullable', 'string', 'max:500'],
            'default_meta_author' => ['nullable', 'string', 'max:255'],
            'default_robots_directive' => ['nullable', 'string', 'max:100'],
            'og_site_name' => ['nullable', 'string', 'max:255'],
            'default_og_type' => ['nullable', 'string', 'max:50'],
            'twitter_card' => ['nullable', 'string', 'max:50'],
            'default_og_image' => ['nullable', 'image', 'max:4096'],
            'default_twitter_image' => ['nullable', 'image', 'max:4096'],
            'remove_default_og_image' => ['nullable', 'boolean'],
            'remove_default_twitter_image' => ['nullable', 'boolean'],
        ]);

        unset($data['remove_default_og_image'], $data['remove_default_twitter_image']);

        if ($request->boolean('remove_default_og_image') && $seo_setting->default_og_image) {
            Storage::disk('public')->delete($seo_setting->default_og_image);
            SeoSetting::unpublishPublicFile($seo_setting->default_og_image);
            $data['default_og_image'] = null;
        }

        if ($request->boolean('remove_default_twitter_image') && $seo_setting->default_twitter_image) {
            Storage::disk('public')->delete($seo_setting->default_twitter_image);
            SeoSetting::unpublishPublicFile($seo_setting->default_twitter_image);
            $data['default_twitter_image'] = null;
        }

        if ($request->hasFile('default_og_image')) {
            if ($seo_setting->default_og_image) {
                Storage::disk('public')->delete($seo_setting->default_og_image);
                SeoSetting::unpublishPublicFile($seo_setting->default_og_image);
            }
            $data['default_og_image'] = $request->file('default_og_image')->store('seo', 'public');
            SeoSetting::publishPublicFile($data['default_og_image']);
        } else {
            unset($data['default_og_image']);
        }

        if ($request->hasFile('default_twitter_image')) {
            if ($seo_setting->default_twitter_image) {
                Storage::disk('public')->delete($seo_setting->default_twitter_image);
                SeoSetting::unpublishPublicFile($seo_setting->default_twitter_image);
            }
            $data['default_twitter_image'] = $request->file('default_twitter_image')->store('seo', 'public');
            SeoSetting::publishPublicFile($data['default_twitter_image']);
        } else {
            unset($data['default_twitter_image']);
        }

        $seo_setting->update($data);
        SeoSetting::clearCache();

        return back()->with('success', 'SEO settings updated.');
    }
}
