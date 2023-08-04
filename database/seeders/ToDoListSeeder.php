<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ToDoListSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $priorities = ['High', 'Low', 'Middle'];

        $userIds = User::pluck('id');

        foreach ($userIds as $userId) {

            $name = $faker->sentence;
            if (Str::length($name) > 50) {
                $name = substr($faker->sentence, 49);
            } else if (Str::length($name) == 0) {
                $name = 'abc cba';
            }

            DB::table('tasks')->insert([
                'name' => $name,
                'description' => $faker->paragraph,
                'priority' => $faker->randomElement($priorities),
                'status' => $faker->boolean,
                'date' => Carbon::now()->addDays(rand(1, 30)), // Add a date for the task
                'user_id' => $userId,
            ]);
        }

    }
}
