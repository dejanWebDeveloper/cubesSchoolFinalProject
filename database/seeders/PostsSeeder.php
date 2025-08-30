<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = DB::table('categories')->get();
        $authors = DB::table('authors')->get();
        DB::table('posts')->truncate();
        $faker = Faker::create();
        for ($i = 1; $i <= 100; $i++) {
            DB::table('posts')->insert([
                'heading' => $faker->name,
                'preheading' => $faker->address,
                'text' => $faker->text,
                'category_id' => $categories->random()->id,
                'author_id' => $authors->random()->id,
                'views' => rand(100, 1000),
                'enable' => rand(0, 1),
                'important' => 0,
                'created_at' => now()]);
        }
    }
}
