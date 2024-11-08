<?php

namespace Database\Seeders;

use App\Modules\Gudang\Models\Gudang;
use App\Modules\UserGudang\Models\UserGudang;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Users::where('username', '=', 'superadmin')->first();
        $gudang = Gudang::create([
            'nama_gudang' => 'Gudang 1 Semarang',
            'alamat' => 'Gunungpati Semarang',
            'no_telp' => '0812345566'
        ]);

        UserGudang::create([
            'id_user' => $user->id,
            'id_gudang' => $gudang->id
        ]);
    }
}
