<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::create([
            'name' => 'mahmoudmiehob', 
            'email' => 'mahmoudmiehob@gmail.com',
            'password' => bcrypt('12345678'),
            'status' => 1,
            'auth_access' => 3,
        ]);
    }
}
