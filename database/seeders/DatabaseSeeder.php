<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Event;
use App\Models\Location;
use App\Models\Media;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        User::factory()->create([
            "name" => "Mahul",
            "email" => "mahul@patel.com",
            "password" => Hash::make('hello'),
        ]);
        User::factory(5)->create();

        Event::factory(5)->create();
        Topic::factory(5)->create();
        Location:: factory(5)->create();
        Media:: factory(5)->create();
        Tag:: factory(5)->create();


    }
}
