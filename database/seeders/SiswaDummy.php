<?php

namespace Database\Seeders;

use App\Models\SiswaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiswaDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        SiswaModel::factory()->count(20)->create();
    }
}
