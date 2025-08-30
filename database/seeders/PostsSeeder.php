<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            $heading = $faker->name;
            DB::table('posts')->insert([
                'heading' => $heading,
                'slug' => Str::slug($heading),
                'preheading' => $faker->address,
                'text' => $faker->text,
                'category_id' => $categories->random()->id,
                'author_id' => $authors->random()->id,
                'enable' => rand(0, 1),
                'important' => 0,
                'created_at' => now()]);
        }
    }
}
