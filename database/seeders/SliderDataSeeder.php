<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            DB::table('slider_data')->insert([
                'heading' => $faker->name,
                'button_name' => 'FIND OUT MORE',
                'url' => 'https://www.php.net/',
                'created_at' => now()]);
        }
    }
}
