<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
            $name = $faker->name;
            DB::table('categories')->insert([
                'name' => $name,
                'description' => $faker->address,
                'slug' => Str::slug($name),
                'priority' => $i,
                'created_at' => now()
            ]);
        }
    }
}
