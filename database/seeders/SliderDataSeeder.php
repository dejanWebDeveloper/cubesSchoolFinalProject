<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SliderDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('slider_data')->truncate();
        $faker = Faker::create();
        for ($i = 1; $i <= 8; $i++) {
            $heading = $faker->name;
            DB::table('slider_data')->insert([
                'heading' => $heading,
                'slug' => Str::slug($heading),
                'button_name' => 'FIND OUT MORE',
                'position' => $i,
                'status' => 1,
                'url' => 'https://www.php.net/',
                'created_at' => now()]);
        }
    }
}
