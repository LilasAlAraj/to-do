<?php

namespace Database\Seeders;

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

        // Insert 10 random ToDoList items into the "to_do_list" table
        for ($i = 1; $i < 10; $i++) {
            $name = $faker->sentence;
            if (Str::length($name) > 50) {
                $name = substr($faker->sentence, 49);
            }
            else if (Str::length($name) == 0) {
                $name = 'abc cba';
            }

            DB::table('tasks')->insert([
                'name' => $name,
                'description' => $faker->paragraph,
                'priority' => $faker->randomElement($priorities),
                'status' => $faker->boolean,
                'date' => Carbon::now()->addDays($i), // Add a date for the task
                'user_id' => $i,
            ]);
        }
    }
}
