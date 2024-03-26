<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        /*
            $table->string('name',255);

            //fk topic
            $table->foreignId("user_id")->constrained();
            //fk location
         */
        return [
            "name" => fake()->sentence(6, true),
            "start_at" => fake()->dateTime(),
            "user_id" => User::all()->random()->id,
            "topic_id" => Topic::all()->random()->id,
            "location_id" => Location::all()->random()->id,
        ];
    }
}
