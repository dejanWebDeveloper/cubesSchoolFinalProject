<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            $name = $faker->name;
            DB::table('authors')->insert([
                'name' => $name,
                'slug' => Str::slug($name),
                'email' => $faker->email,
                'created_at' => now()]);
        }
    }
}
