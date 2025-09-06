<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            User::updateOrCreate(
                ['email' => 'admin'.$i.'@example.com'],
                [
                    'name' => 'Admin '.$i,
                    'password' => Hash::make('admin555'),
                    'phone' => 064/1234-567,
                    'status' => 1
                ]
            );
        }

    }
}
