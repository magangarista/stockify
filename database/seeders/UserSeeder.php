<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@stockify.test'],
            [
                'name' => 'Admin Stockify',
                'password' => Hash::make('password'),
                'role' => 'Admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'manajer@stockify.test'],
            [
                'name' => 'Manajer Gudang',
                'password' => Hash::make('password'),
                'role' => 'Manajer Gudang',
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@stockify.test'],
            [
                'name' => 'Staff Gudang',
                'password' => Hash::make('password'),
                'role' => 'Staff Gudang',
            ]
        );
    }
}