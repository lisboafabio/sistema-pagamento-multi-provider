<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = 'secret';
        $email = 'user@email.com';
        User::firstOrCreate(['email' => $email], [
            'name' => 'user',
            'email' => $email,
            'password' => $password
        ]);
    }
}
