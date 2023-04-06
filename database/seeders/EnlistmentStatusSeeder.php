<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enlistment_statue;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EnlistmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('enlistment_statues')->delete();

        $data = [
            [
                'name' => 'معفي',
            ],
            [
                'name' => 'وحيد',
            ],
            [
                'name' => 'مجند',
            ],
            [
                'name' => 'مؤجل',
            ],
        ];

        Enlistment_statue::insert($data);
    }
}
