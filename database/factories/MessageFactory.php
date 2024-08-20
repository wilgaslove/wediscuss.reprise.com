<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $senderId = fake()->randomElement([0, 1]);
        if ($senderId === 0) {
            $senderId = fake()->randomElement(\App\Models\User::where('id', '!=', 1)->pluck('id')->toArry());
            $receiverId = 1;
        }
        return [
            'message' => fake()->realText(),
            // 'sender_id' =>fake()-> '' ,
            // 'receiver_id' =>fake()-> '',
            // 'group_id' =>fake()-> '',
            // 'conversation_id' =>fake()-> '',
        ];
    }
}
