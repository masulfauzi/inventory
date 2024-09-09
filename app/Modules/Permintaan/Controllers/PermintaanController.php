<?php
namespace App\Modules\Permintaan\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Permintaan\Models\Permintaan;
use App\Modules\Status\Models\Status;
use App\Modules\Users\Models\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PermintaanController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Permintaan";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Permintaan::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Permintaan::permintaan', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_status = Status::all()->pluck('status_permintaan','id');
		$ref_users = Users::all()->pluck('name','id');
		
		$data['forms'] = array(
			'id_status' => ['Status', Form::select("id_status", $ref_status, null, ["class" => "form-control select2"]) ],
			'id_user' => ['User', Form::select("id_user", $ref_users, null, ["class" => "form-control select2"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Permintaan::permintaan_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_status' => 'required',
			'id_user' => 'required',
			
		]);

		$permintaan = new Permintaan();
		$permintaan->id_status = $request->input("id_status");
		$permintaan->id_user = $request->input("id_user");
		
		$permintaan->created_by = Auth::id();
		$permintaan->save();

		$text = 'membuat '.$this->title; //' baru '.$permintaan->what;
		$this->log($request, $text, ['permintaan.id' => $permintaan->id]);
		return redirect()->route('permintaan.index')->with('message_success', 'Permintaan berhasil ditambahkan!');
	}

	public function show(Request $request, Permintaan $permintaan)
	{
		$data['permintaan'] = $permintaan;

		$text = 'melihat detail '.$this->title;//.' '.$permintaan->what;
		$this->log($request, $text, ['permintaan.id' => $permintaan->id]);
		return view('Permintaan::permintaan_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Permintaan $permintaan)
	{
		$data['permintaan'] = $permintaan;

		$ref_status = Status::all()->pluck('status_permintaan','id');
		$ref_users = Users::all()->pluck('name','id');
		
		$data['forms'] = array(
			'id_status' => ['Status', Form::select("id_status", $ref_status, null, ["class" => "form-control select2"]) ],
			'id_user' => ['User', Form::select("id_user", $ref_users, null, ["class" => "form-control select2"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$permintaan->what;
		$this->log($request, $text, ['permintaan.id' => $permintaan->id]);
		return view('Permintaan::permintaan_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_status' => 'required',
			'id_user' => 'required',
			
		]);
		
		$permintaan = Permintaan::find($id);
		$permintaan->id_status = $request->input("id_status");
		$permintaan->id_user = $request->input("id_user");
		
		$permintaan->updated_by = Auth::id();
		$permintaan->save();


		$text = 'mengedit '.$this->title;//.' '.$permintaan->what;
		$this->log($request, $text, ['permintaan.id' => $permintaan->id]);
		return redirect()->route('permintaan.index')->with('message_success', 'Permintaan berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$permintaan = Permintaan::find($id);
		$permintaan->deleted_by = Auth::id();
		$permintaan->save();
		$permintaan->delete();

		$text = 'menghapus '.$this->title;//.' '.$permintaan->what;
		$this->log($request, $text, ['permintaan.id' => $permintaan->id]);
		return back()->with('message_success', 'Permintaan berhasil dihapus!');
	}

}
