<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Major::create([
            'name' => 'Teknik Informatika',
            'code' => 'TIF',
            'description' => 'Program studi yang mempelajari teknologi informasi, pemrograman, dan pengembangan software',
        ]);

        Major::create([
            'name' => 'Akuntansi',
            'code' => 'AKT',
            'description' => 'Program studi yang mempelajari akuntansi, keuangan, dan manajemen bisnis',
        ]);

        Major::create([
            'name' => 'Administrasi Bisnis',
            'code' => 'AB',
            'description' => 'Program studi yang mempelajari manajemen bisnis dan administrasi perusahaan',
        ]);
    }
}
