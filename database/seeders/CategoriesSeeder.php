<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use function Sodium\increment;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->truncate();
        $faker = Faker::create();
        for ($i = 1; $i <= 10; $i++) {
            DB::table('categories')->insert([
                'name' => $faker->name,
                'description' => $faker->address,
                'priority' => $i,
                'created_at' => now()]);
        }
    }
}
