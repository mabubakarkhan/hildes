<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactSettingController extends Controller
{
    public function index()
    {
        $setting = ContactSetting::query()->firstOrCreate([]);

        return view('admin.contact-settings.index', compact('setting'));
    }

    public function update(Request $request, ContactSetting $contact_setting)
    {
        $contactSetting = $contact_setting;
        $data = $request->validate([
            'phone' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'github' => ['nullable', 'url', 'max:255'],
            'address_line' => ['nullable', 'string', 'max:255'],
            'google_map_url' => ['nullable', 'url', 'max:255'],
            'google_map_embed' => ['nullable', 'string'],
            'extra_notes' => ['nullable', 'string'],
            'header_logo' => ['nullable', 'image', 'max:2048'],
            'footer_logo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('header_logo')) {
            if ($contactSetting->header_logo) {
                Storage::disk('public')->delete($contactSetting->header_logo);
            }
            $data['header_logo'] = $request->file('header_logo')->store('logos', 'public');
        }

        if ($request->hasFile('footer_logo')) {
            if ($contactSetting->footer_logo) {
                Storage::disk('public')->delete($contactSetting->footer_logo);
            }
            $data['footer_logo'] = $request->file('footer_logo')->store('logos', 'public');
        }

        $contactSetting->update($data);

        return back()->with('success', 'Contact settings updated.');
    }
}
