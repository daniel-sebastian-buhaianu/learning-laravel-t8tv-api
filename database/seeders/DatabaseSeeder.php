<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\UserRole;
use App\Models\User;
use App\Models\VideoCategory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        UserRole::create([
            'name' => 'Member'
        ]);

        UserRole::create([
            'name' => 'Moderator'
        ]);

        UserRole::create([
            'name' => 'Administrator'
        ]);

        User::create([
            'user_role_id' => 3,
            'first_name' => 'Daniel',
            'last_name' => 'Buhaianu',
            'email' => 'daniel.buhaianu@gmail.com',
            'password' => Hash::make('Abc123000!')
        ]);

        User::create([
            'user_role_id' => 3,
            'first_name' => 'Andrew',
            'last_name' => 'Tate',
            'email' => 'andrew.tate@gmail.com',
            'password' => Hash::make('Abc123000!')
        ]);

        User::create([
            'user_role_id' => 2,
            'first_name' => 'Tristan',
            'last_name' => 'Tate',
            'email' => 'tristan.tate@gmail.com',
            'password' => Hash::make('Abc123000!')
        ]);

        User::create([
            'user_role_id' => 2,
            'first_name' => 'Cousin',
            'last_name' => 'Luke',
            'email' => 'cousin.luke@gmail.com',
            'password' => Hash::make('Abc123000!')
        ]);

        User::create([
            'user_role_id' => 1,
            'first_name' => 'Some',
            'last_name' => 'Dork',
            'email' => 'some.dork@gmail.com',
            'password' => Hash::make('Abc123000!')
        ]);

        User::create([
            'user_role_id' => 2,
            'first_name' => 'Another',
            'last_name' => 'Dork',
            'email' => 'another.dork@gmail.com',
            'password' => Hash::make('Abc123000!')
        ]);

        VideoCategory::create([
            'name' => 'Tate Confidential'
        ]);

        VideoCategory::create([
            'name' => 'Tate Speech'
        ]);

        addRumbleChannelToDatabase(
            getRumbleChannelAboutData('https://rumble.com/c/tateconfidential')['data']
        );

        addRumbleChannelToDatabase(
            getRumbleChannelAboutData('https://rumble.com/c/TateSpeech')['data']
        );

        addRumbleVideosToDatabase('https://rumble.com/c/tateconfidential');
        
        addRumbleVideosToDatabase('https://rumble.com/c/TateSpeech');
    }
}