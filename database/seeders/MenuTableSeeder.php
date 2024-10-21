<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Modules\Menu\Models\Menu;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $main = Menu::create([
            'menu' => 'Main Menu',
            'module' => 'no',
            'routing' => 'no',
            'is_tampil' => 1,
            'icon' => 'fa-folder',
            'urutan' => 1,
            'parent_id' => '-',
            'level' => 0
        ]);
        $man = Menu::create([
            'menu' => 'Management Menu',
            'module' => 'no',
            'routing' => 'no',
            'is_tampil' => 1,
            'icon' => 'fa-folder',
            'urutan' => 2,
            'parent_id' => '-',
            'level' => 0
        ]);
        $dev = Menu::create([
            'menu' => 'Advance Menu',
            'module' => 'no',
            'routing' => 'no',
            'is_tampil' => 1,
            'icon' => 'fa-folder',
            'urutan' => 3,
            'parent_id' => '-',
            'level' => 0
        ]);
        $ref = Menu::create([
            'menu' => 'Referensi',
            'module' => 'no',
            'routing' => 'no',
            'is_tampil' => 1,
            'icon' => 'fa-folder',
            'urutan' => 4,
            'parent_id' => '-',
            'level' => 0
        ]);
        Menu::create([
            'menu' => 'Dashboard',
            'module' => 'dashboard',
            'routing' => 'dashboard',
            'is_tampil' => 1,
            'icon' => 'fa-tachometer-alt',
            'urutan' => 1,
            'parent_id' => $main->id,
            'level' => 1
        ]);
        Menu::create([
            'menu' => 'Master Barang',
            'module' => 'barang',
            'routing' => 'barang.index',
            'is_tampil' => 1,
            'icon' => 'fa-folder',
            'urutan' => 2,
            'parent_id' => $main->id,
            'level' => 1
        ]);
        Menu::create([
            'menu' => 'Konfigurasi',
            'module' => 'config',
            'routing' => 'config.index',
            'is_tampil' => 1,
            'icon' => 'fa-cogs',
            'urutan' => 2,
            'parent_id' => $man->id,
            'level' => 1
        ]);
        Menu::create([
            'menu' => 'User',
            'module' => 'users',
            'routing' => 'users.index',
            'is_tampil' => 1,
            'icon' => 'fa-user',
            'urutan' => 3,
            'parent_id' => $man->id,
            'level' => 1
        ]);

        // dev
        Menu::create([
            'menu' => 'Role',
            'module' => 'role',
            'routing' => 'role.index',
            'is_tampil' => 1,
            'icon' => 'fa-user-tag',
            'urutan' => 1,
            'parent_id' => $dev->id,
            'level' => 1
        ]);
        Menu::create([
            'menu' => 'Menu',
            'module' => 'menu',
            'routing' => 'menu.index',
            'is_tampil' => 1,
            'icon' => 'fa-list',
            'urutan' => 2,
            'parent_id' => $dev->id,
            'level' => 1
        ]);
        Menu::create([
            'menu' => 'Privilege',
            'module' => 'privilege',
            'routing' => 'privilege.index',
            'is_tampil' => 0,
            'icon' => 'fa-user-cog',
            'urutan' => 3,
            'parent_id' => $dev->id,
            'level' => 1
        ]);
        Menu::create([
            'menu' => 'Storage',
            'module' => 'files',
            'routing' => 'files.index',
            'is_tampil' => 1,
            'icon' => 'fa-box-open',
            'urutan' => 4,
            'parent_id' => $dev->id,
            'level' => 1
        ]);
        Menu::create([
            'menu' => 'Jenis File',
            'module' => 'jenisfile',
            'routing' => 'jenisfile.index',
            'is_tampil' => 0,
            'icon' => 'fa-boxes',
            'urutan' => 5,
            'parent_id' => $dev->id,
            'level' => 1
        ]);
        Menu::create([
            'menu' => 'Log',
            'module' => 'log',
            'routing' => 'log.index',
            'is_tampil' => 1,
            'icon' => 'fa-wave-square',
            'urutan' => 6,
            'parent_id' => $dev->id,
            'level' => 1
        ]);
        Menu::create([
            'menu' => 'Satuan',
            'module' => 'satuan',
            'routing' => 'satuan.index',
            'is_tampil' => 1,
            'icon' => 'fa-folder',
            'urutan' => 1,
            'parent_id' => $ref->id,
            'level' => 1
        ]);
        Menu::create([
            'menu' => 'Gudang',
            'module' => 'gudang',
            'routing' => 'gudang.index',
            'is_tampil' => 1,
            'icon' => 'fa-folder',
            'urutan' => 1,
            'parent_id' => $ref->id,
            'level' => 1
        ]);
        Menu::create([
            'menu' => 'Status',
            'module' => 'status',
            'routing' => 'status.index',
            'is_tampil' => 1,
            'icon' => 'fa-folder',
            'urutan' => 1,
            'parent_id' => $ref->id,
            'level' => 1
        ]);
        Menu::create([
            'menu' => 'Kategori',
            'module' => 'kategori',
            'routing' => 'kategori.index',
            'is_tampil' => 1,
            'icon' => 'fa-folder',
            'urutan' => 1,
            'parent_id' => $ref->id,
            'level' => 1
        ]);

        // Menu::create([
        //     'menu' => 'Backup & Restore',
        //     'module' => 'backup',
        //     'routing' => 'backup.index',
        //     'is_tampil' => 1,
        //     'icon' => 'fa-archive',
        //     'urutan' => 2,
        //     'parent_id' => $man->id,
        //     'level' => 1
        // ]);
    }
}
