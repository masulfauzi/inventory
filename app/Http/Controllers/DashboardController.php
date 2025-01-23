<?php

namespace App\Http\Controllers;

use App\Helpers\Permission;
use App\Modules\Barang\Models\Barang;
use App\Modules\Gudang\Models\Gudang;
use App\Modules\Permintaan\Models\Permintaan;
use App\Modules\Users\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
    public function index()
    {
        // dd(session('active_role')['role']);
        if (session('active_role')['role'] == 'Super Admin') {
            $data['barang'] = Barang::all();
            $data['gudang'] = Gudang::all();
            $data['users'] = Users::all();
            $data['permintaan'] = Permintaan::all();
            $data['chart'] = Permintaan::select('status_permintaan', DB::raw('count(*) as jumlah'))
                ->join('status', 'permintaan.id_status', '=', 'status.id')->groupBy('id_status')->get();
            // dd($barang);
            return view('dashboard_super', $data);
        } elseif (session('active_role')['role'] == 'Admin Gudang') {
            $data['barang'] = Barang::all();
            $data['permintaan'] = Permintaan::join('status', 'permintaan.id_status', '=', 'status.id')->get();
            $data['chart'] = Permintaan::select('status_permintaan', DB::raw('count(*) as jumlah'))
                ->join('status', 'permintaan.id_status', '=', 'status.id')->groupBy('id_status')->get();
            return view('dashboard_admin', $data);
        } else {
            $data['barang'] = Barang::all();
            $data['permintaan'] = Permintaan::join('status', 'permintaan.id_status', '=', 'status.id')->get();
            $data['chart'] = Permintaan::select('status_permintaan', DB::raw('count(*) as jumlah'))
            ->join('status', 'permintaan.id_status', '=', 'status.id')->groupBy('id_status')->get();
            return view('dashboard', $data);
        }
    }

    public function changeRole($id_role)
    {
        $user = Auth::user();

        // get user's role
        $roles = Permission::getRole($user->id);
        if ($roles->count() == 0) abort(403);
        $active_role = $roles->where('id', $id_role)->first()->only(['id', 'role']);
        // dd($active_role);
        // get user's menu
        $menus = Permission::getMenu($active_role);

        // get user's privilege
        $privileges = Permission::getPrivilege($active_role);
        $privileges = $privileges->mapWithKeys(function ($item, $key) {
            return [$item['module'] => $item->only(['create', 'read', 'update', 'delete', 'show_menu', 'show'])];
        });

        // store to session
        session(['menus' => $menus]);
        session(['roles' => $roles->pluck('role', 'id')->all()]);
        session(['privileges' => $privileges->all()]);
        session(['active_role' => $active_role]);

        return redirect()->route('dashboard')->with('message_success', 'Berhasil memperbarui role/session sebagai ' . $active_role['role']);
    }

    public function change_gudang($id_gudang)
    {
        $gudang = Gudang::select('id', 'nama_gudang')->find($id_gudang);

        session(['active_gudang' => $gudang]);

        return redirect()->back()->with('message_success', 'Berhasil memperbarui gudang aktif');
    }

    public function forceLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
