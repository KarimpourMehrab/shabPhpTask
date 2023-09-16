<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        User::query()->create([
            'name' => 'محراب کریم پور',
            'mobile' => '09054603316',
            'password' => Hash::make('121212')
        ]);
        User::factory(100)->create();
    }
}
