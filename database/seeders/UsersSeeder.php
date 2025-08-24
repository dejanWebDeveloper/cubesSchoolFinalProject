<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i<6; $i++)
        {
            DB::table('users')->insert([
                'name' => 'admin'.$i,
                'email' => 'admin'.$i.'@example.com',
                'password' => Hash::make('admin555'),
                'created_at' => now()
            ]);
        }

    }
}
