<?php
namespace App\Modules\UserGudang\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\UserGudang\Models\UserGudang;
use App\Modules\Users\Models\Users;
use App\Modules\Gudang\Models\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserGudangController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "User Gudang";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = UserGudang::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('UserGudang::usergudang', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_users = Users::all()->pluck('name','id');
		$ref_gudang = Gudang::all()->pluck('nama_gudang','id');
		
		$data['forms'] = array(
			'id_user' => ['User', Form::select("id_user", $ref_users, null, ["class" => "form-control select2"]) ],
			'id_gudang' => ['Gudang', Form::select("id_gudang", $ref_gudang, null, ["class" => "form-control select2"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('UserGudang::usergudang_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_user' => 'required',
			'id_gudang' => 'required',
			
		]);

		$usergudang = new UserGudang();
		$usergudang->id_user = $request->input("id_user");
		$usergudang->id_gudang = $request->input("id_gudang");
		
		$usergudang->created_by = Auth::id();
		$usergudang->save();

		$text = 'membuat '.$this->title; //' baru '.$usergudang->what;
		$this->log($request, $text, ['usergudang.id' => $usergudang->id]);
		return redirect()->route('usergudang.index')->with('message_success', 'User Gudang berhasil ditambahkan!');
	}

	public function show(Request $request, UserGudang $usergudang)
	{
		$data['usergudang'] = $usergudang;

		$text = 'melihat detail '.$this->title;//.' '.$usergudang->what;
		$this->log($request, $text, ['usergudang.id' => $usergudang->id]);
		return view('UserGudang::usergudang_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, UserGudang $usergudang)
	{
		$data['usergudang'] = $usergudang;

		$ref_users = Users::all()->pluck('name','id');
		$ref_gudang = Gudang::all()->pluck('nama_gudang','id');
		
		$data['forms'] = array(
			'id_user' => ['User', Form::select("id_user", $ref_users, null, ["class" => "form-control select2"]) ],
			'id_gudang' => ['Gudang', Form::select("id_gudang", $ref_gudang, null, ["class" => "form-control select2"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$usergudang->what;
		$this->log($request, $text, ['usergudang.id' => $usergudang->id]);
		return view('UserGudang::usergudang_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_user' => 'required',
			'id_gudang' => 'required',
			
		]);
		
		$usergudang = UserGudang::find($id);
		$usergudang->id_user = $request->input("id_user");
		$usergudang->id_gudang = $request->input("id_gudang");
		
		$usergudang->updated_by = Auth::id();
		$usergudang->save();


		$text = 'mengedit '.$this->title;//.' '.$usergudang->what;
		$this->log($request, $text, ['usergudang.id' => $usergudang->id]);
		return redirect()->route('usergudang.index')->with('message_success', 'User Gudang berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$usergudang = UserGudang::find($id);
		$usergudang->deleted_by = Auth::id();
		$usergudang->save();
		$usergudang->delete();

		$text = 'menghapus '.$this->title;//.' '.$usergudang->what;
		$this->log($request, $text, ['usergudang.id' => $usergudang->id]);
		return back()->with('message_success', 'User Gudang berhasil dihapus!');
	}

}
