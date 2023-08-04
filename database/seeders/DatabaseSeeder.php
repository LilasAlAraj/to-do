<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $userIds = User::pluck('id');


        // checking if there is not any user then create users by calling user seeder
        if (count($userIds) === 0) {

            $this->call(UserSeeder::class);

        }
        // create tasks by calling the ToDoList seeder
        $this->call(ToDoListSeeder::class);


    }
}
