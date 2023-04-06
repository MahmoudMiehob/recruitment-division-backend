<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->delete();

        $data = [
            [
                'id'   => 1,
                'name' => 'مفعل',
            ],
            [
                'id'   => 2,
                'name' => 'غير مفعل',
            ]
        ];

        DB::table('status')->insert($data);
        
    }
}
