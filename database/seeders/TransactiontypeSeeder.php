<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactiontypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactiontypes')->delete();

        $data = [
            [
                'type' => 'تأجيل دراسي',
            ],
            [
                'type' => 'وحيد',
            ],
            [
                'type' => 'اذن سفر',
            ],
            [
                'type' => 'بيان وضع',
            ],
        ];
        DB::table('transactiontypes')->insert($data);
    }
}
