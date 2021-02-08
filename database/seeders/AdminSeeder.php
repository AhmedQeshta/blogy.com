<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'admin',
            'email' => 'admin@blogy.com',
            'password' => Hash::make('admin@blogy.com'),
        ]);
        User::create([
            'name' => 'user',
            'email' => 'user@blogy.com.test',
            'password' => Hash::make('user@blogy.com.test'),
        ]);
    }
}
