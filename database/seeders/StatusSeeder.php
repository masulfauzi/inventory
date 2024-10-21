<?php

namespace Database\Seeders;

use App\Modules\Status\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'status_permintaan' => 'Pengajuan',
            'urutan' => '1'
        ]);
        Status::create([
            'status_permintaan' => 'Diproses',
            'urutan' => '2'
        ]);
        Status::create([
            'status_permintaan' => 'Siap Diambil',
            'urutan' => '3'
        ]);
        Status::create([
            'status_permintaan' => 'Selesai',
            'urutan' => '4'
        ]);
    }
}
