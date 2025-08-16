<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('authors')->truncate();
        $faker = Faker::create();
        for ($i = 1; $i <= 7; $i++) {
            DB::table('authors')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'profile_photo' => $i.'.jpg',
                'created_at' => now()]);
        }
    }
}
