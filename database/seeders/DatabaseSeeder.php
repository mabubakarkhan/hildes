<?php

namespace Database\Seeders;

use App\Models\ContactSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(['username' => 'admin'], [
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@hildes.local',
            'password' => Hash::make('chor'),
            'is_admin' => true,
        ]);

        ContactSetting::query()->firstOrCreate([]);

        $this->call(ServicePageSaaSDevelopmentSeeder::class);
        $this->call(ServicePageCustomWebDevelopmentSeeder::class);
        $this->call(ServicePageMvpDevelopmentSeeder::class);
        $this->call(ServicePageAiAutomationSeeder::class);
        $this->call(ServicePageCloudDevopsSeeder::class);
        $this->call(ServicePageAiAppRescueSeeder::class);
        $this->call(ServicePageEcommerceDevelopmentSeeder::class);
        $this->call(ServicePageUiUxDesignSeeder::class);
        $this->call(ServicePageApiDevelopmentSeeder::class);
        $this->call(ServicePageMobileAppDevelopmentSeeder::class);
    }
}
