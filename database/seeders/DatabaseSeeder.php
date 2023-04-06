<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ProvincesSeeder;
use Database\Seeders\TransactiontypeSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        $this->call(UserSeeder::class); //run Userseeder 
        $this->call(ProvincesSeeder::class); //run ProvincesSeeder 
        $this->call(TransactiontypeSeeder::class); //run TransactiontypeSeeder 
        $this->call(RoleSeeder::class); //run RoleSeeder 
    }
}
