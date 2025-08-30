<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->truncate();
        $faker = Faker::create();
        for ($i = 1; $i <= 10; $i++) {
            $name = $faker->name;
            DB::table('tags')->insert([
                'name' => $name,
                'slug' => Str::slug($name),
                'created_at' => now()]);
        }
    }
}
