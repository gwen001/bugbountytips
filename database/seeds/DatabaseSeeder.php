<?php

use Illuminate\Database\Seeder;
use App\Tweet;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        factory(Tweet::class, 10)->create();
    }
}
