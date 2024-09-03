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

        // dd(User::RANK_ADMIN);

        User::factory()->create([
            "name" => "Mahul",
            "email" => "mahul@patel.com",
            "password" => Hash::make('hello'),
            "rank" => User::RANK_ADMIN,
        ]);
        User::factory()->create([
            "name" => "Ludo",
            "email" => "brient@tikyus.co.jp",
            "password" => '$2y$12$HxyMiFPXCra69vsnsIQosOjwUXcuEN53HwO6iJw7VEuINcjvqnoSa',
            "rank" => User::RANK_ADMIN,
        ]);
        User::factory()->create([
            "name" => "Admin",
            "email" => "admin@mail.com",
            "password" => 'admin',
            "rank" => User::RANK_ADMIN,
        ]);
        User::factory()->create([
            "name" => "Support",
            "email" => "support@mail.com",
            "password" => 'admin',
            "rank" => User::RANK_SUPPORT,
        ]);
        User::factory()->create([
            "name" => "Visitor",
            "email" => "visitor@mail.com",
            "password" => 'admin',
            "rank" => User::RANK_VISITOR,
        ]);


        User::factory(5)->create();

        // Tag::factory(5)->create();
        Topic::factory()->create([
            "name" => "What is your recipe?",
            "slug" => "hirosegawa-imonikai",
            "description_en" => "What is your recipe?",
            "description_ja" => "これのレシピは何ですか？",
        ]);
        Location::factory()->create([
            "name" => "Hirosegawa BBQ Square",
            "slug" => "hirosegawa-bbq-square",
            "description_en" => "Hirosegawa BBQ Square",
        ]);
        Event::factory()->create([
            "name" => "2024 Hirosegawa Imonikai",
            "slug" => "2024-hirosegawa-imonikai",
            "description_en" => "<h1>the first GoGoGo Imonikai!</h1><p><br></p><p>Our first, certainly, but not the least!</p><p>Let's cook some <strong>meet</strong>, <strong>veggies</strong>, <strong>fish</strong>, <strong>mocchi</strong> and some more!</p><p><br></p><p><em>Reach us in case of allergy, or bring something you are safe to eat</em></p><p>And let's have a tons of fun.</p>",
            "description_ja" => "<h1>初めての GoGoGo 芋煮会！</h1><p><br></p><p>初めての開催ですが、絶対に特別なイベントです！</p><p>お肉、野菜、魚、餅など、いろいろなものを料理しましょう！</p><p><br></p><p><em>アレルギーがある場合はご連絡いただくか、安全に食べられるものをお持ちください。</em></p><p>たくさん楽しみましょう！</p>",
            "start_at" => "2024-02-01 12:00:00",
            "end_at" => "2024-02-01 14:00:00",
            "location_id" => 1,
            "topic_id" => 1,
            "user_id" => 1,
            "published_at" => "2024-09-03",
        ]);
        Topic::factory(5)->create();
        Location::factory(5)->create();
        Media::factory(5)->create();
        Event::factory(5)->create();


    }
}
