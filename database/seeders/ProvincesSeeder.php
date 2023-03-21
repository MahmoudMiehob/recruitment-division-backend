<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProvincesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->delete();
        $data = [
            [
                'name' => 'طرطوس',
            ],
            [
                'name' => 'حمص',
            ],
            [
                'name' => 'حماة',
            ],
            [
                'name' => 'دمشق',
            ],
            [
                'name' => 'حلب',
            ],
            [
                'name' => 'درعا',
            ],
            [
                'name' => 'الرقة',
            ],
            [
                'name' => 'الحسكة',
            ],
            [
                'name' => 'دير الزور',
            ],
            [
                'name' => 'ادلب',
            ],
            [
                'name' => 'اللاذقية',
            ],
            [
                'name' => 'السويداء',
            ],
            [
                'name' => 'ريف دمشق',
            ],
            [
                'name' => 'القنيطرة',
            ],
        ];

        Province::insert($data);
    }
}
