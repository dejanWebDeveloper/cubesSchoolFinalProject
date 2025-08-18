<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            DB::table('tags')->insert([
                'name' => $faker->name,
                'created_at' => now()]);
        }
    }
}
