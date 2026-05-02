<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::query()->ordered()->get();

        return view('admin.clients.index', compact('clients'));
    }

    public function order()
    {
        $clients = Client::query()->ordered()->get(['id', 'logo', 'display_order', 'is_active']);

        return view('admin.clients.order', compact('clients'));
    }

    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'order' => ['required', 'array', 'min:1'],
            'order.*' => ['required', 'integer', 'exists:clients,id', 'distinct'],
        ]);

        $ids = collect($validated['order'])->map(fn ($id) => (int) $id)->values();
        $allIds = Client::query()->pluck('id')->map(fn ($id) => (int) $id);
        $missing = $allIds->diff($ids)->values();
        $finalOrder = $ids->merge($missing)->values();

        DB::transaction(function () use ($finalOrder): void {
            foreach ($finalOrder as $index => $id) {
                Client::query()
                    ->whereKey($id)
                    ->update(['display_order' => $index + 1]);
            }
        });

        return redirect()->route('admin.clients.order')->with('success', 'Clients order updated successfully.');
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function bulkCreate()
    {
        return view('admin.clients.bulk-upload');
    }

    public function bulkColors()
    {
        $clients = Client::query()->ordered()->get(['id', 'logo', 'background_color']);

        return view('admin.clients.bulk-colors', compact('clients'));
    }

    public function bulkColorsUpdate(Request $request)
    {
        $validated = $request->validate([
            'background_colors' => ['required', 'array', 'min:1'],
            'background_colors.*' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        DB::transaction(function () use ($validated): void {
            foreach ($validated['background_colors'] as $id => $color) {
                if (! is_numeric($id)) {
                    continue;
                }
                Client::query()
                    ->whereKey((int) $id)
                    ->update(['background_color' => strtoupper($color)]);
            }
        });

        return redirect()->route('admin.clients.bulk-colors')->with('success', 'Client background colors updated.');
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'logos' => ['required', 'array', 'min:1'],
            'logos.*' => ['required', 'image', 'max:4096'],
        ]);

        $maxOrder = (int) Client::query()->max('display_order');
        $logos = $validated['logos'] ?? [];

        DB::transaction(function () use ($logos, $maxOrder): void {
            foreach (array_values($logos) as $index => $logo) {
                /** @var \Illuminate\Http\UploadedFile $logo */
                $upload = $this->storeLogo($logo);
                Client::query()->create([
                    'logo' => $upload['path'],
                    'logo_original_name' => $upload['original_name'],
                    'background_color' => '#FFFFFF',
                    'display_order' => $maxOrder + $index + 1,
                    'is_active' => true,
                ]);
            }
        });

        return redirect()->route('admin.clients.index')->with('success', 'Client logos uploaded successfully.');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePayload($request, true);
        $logo = $request->file('logo');
        $upload = $this->storeLogo($logo);
        $validated['logo'] = $upload['path'];
        $validated['logo_original_name'] = $upload['original_name'];

        Client::query()->create($validated);

        return redirect()->route('admin.clients.index')->with('success', 'Client created successfully.');
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $this->validatePayload($request, false);

        if ($request->hasFile('logo')) {
            if ($client->logo) {
                Storage::disk('public')->delete($client->logo);
            }
            $upload = $this->storeLogo($request->file('logo'));
            $validated['logo'] = $upload['path'];
            $validated['logo_original_name'] = $upload['original_name'];
        }

        $client->update($validated);

        return redirect()->route('admin.clients.edit', $client)->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        if ($client->logo) {
            Storage::disk('public')->delete($client->logo);
        }
        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Client removed successfully.');
    }

    private function validatePayload(Request $request, bool $logoRequired): array
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'background_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'display_order' => ['nullable', 'integer', 'min:0', 'max:999999'],
            'is_active' => ['nullable', 'boolean'],
            'logo' => $logoRequired
                ? ['required', 'image', 'max:4096']
                : ['nullable', 'image', 'max:4096'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['display_order'] = (int) ($validated['display_order'] ?? 0);
        $validated['background_color'] = strtoupper((string) ($validated['background_color'] ?? '#FFFFFF'));

        return $validated;
    }

    /**
     * @return array{path: string, original_name: string}
     */
    private function storeLogo(\Illuminate\Http\UploadedFile $file): array
    {
        $path = $file->store('clients', 'public');

        return [
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
        ];
    }
}
