<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeHeroSetting;
use App\Models\HomeHeroSlide;
use Illuminate\Http\Request;

class HomeHeroController extends Controller
{
    public function index()
    {
        $settings = HomeHeroSetting::getSingleton();
        $slides = HomeHeroSlide::query()->orderBy('sort_order')->orderBy('id')->get();

        return view('admin.home-hero.index', compact('settings', 'slides'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'aspect_ratio_width' => ['required', 'integer', 'min:1', 'max:9999'],
            'aspect_ratio_height' => ['required', 'integer', 'min:1', 'max:9999'],
        ]);

        HomeHeroSetting::getSingleton()->update($validated);

        return redirect()->route('admin.home-hero.index')->with('success', 'Hero settings updated.');
    }
}
