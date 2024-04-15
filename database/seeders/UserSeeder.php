<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run() {
        User::query()->insert([
            [
                'first_name' => 'koushik',
                'last_name' => 'balo',
                'email' => 'koushik@gmail.com',
                'date_of_birth' => '1995-06-01',
                'password' => Hash::make('123456'),
                'is_admin' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'papon',
                'last_name' => 'koushik',
                'email' => 'papon@gmail.com',
                'date_of_birth' => '1995-06-01',
                'password' => Hash::make('123456'),
                'is_admin' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

    }
}
