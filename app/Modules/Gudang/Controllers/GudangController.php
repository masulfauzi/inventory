<?php
namespace App\Modules\Gudang\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Gudang\Models\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GudangController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Gudang";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Gudang::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Gudang::gudang', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'nama_gudang' => ['Nama Gudang', Form::text("nama_gudang", old("nama_gudang"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'alamat' => ['Alamat', Form::text("alamat", old("alamat"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'no_telp' => ['No Telp', Form::text("no_telp", old("no_telp"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Gudang::gudang_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'nama_gudang' => 'required',
			'alamat' => 'required',
			'no_telp' => 'required',
			
		]);

		$gudang = new Gudang();
		$gudang->nama_gudang = $request->input("nama_gudang");
		$gudang->alamat = $request->input("alamat");
		$gudang->no_telp = $request->input("no_telp");
		
		$gudang->created_by = Auth::id();
		$gudang->save();

		$text = 'membuat '.$this->title; //' baru '.$gudang->what;
		$this->log($request, $text, ['gudang.id' => $gudang->id]);
		return redirect()->route('gudang.index')->with('message_success', 'Gudang berhasil ditambahkan!');
	}

	public function show(Request $request, Gudang $gudang)
	{
		$data['gudang'] = $gudang;

		$text = 'melihat detail '.$this->title;//.' '.$gudang->what;
		$this->log($request, $text, ['gudang.id' => $gudang->id]);
		return view('Gudang::gudang_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Gudang $gudang)
	{
		$data['gudang'] = $gudang;

		
		$data['forms'] = array(
			'nama_gudang' => ['Nama Gudang', Form::text("nama_gudang", $gudang->nama_gudang, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nama_gudang"]) ],
			'alamat' => ['Alamat', Form::text("alamat", $gudang->alamat, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "alamat"]) ],
			'no_telp' => ['No Telp', Form::text("no_telp", $gudang->no_telp, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "no_telp"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$gudang->what;
		$this->log($request, $text, ['gudang.id' => $gudang->id]);
		return view('Gudang::gudang_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'nama_gudang' => 'required',
			'alamat' => 'required',
			'no_telp' => 'required',
			
		]);
		
		$gudang = Gudang::find($id);
		$gudang->nama_gudang = $request->input("nama_gudang");
		$gudang->alamat = $request->input("alamat");
		$gudang->no_telp = $request->input("no_telp");
		
		$gudang->updated_by = Auth::id();
		$gudang->save();


		$text = 'mengedit '.$this->title;//.' '.$gudang->what;
		$this->log($request, $text, ['gudang.id' => $gudang->id]);
		return redirect()->route('gudang.index')->with('message_success', 'Gudang berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$gudang = Gudang::find($id);
		$gudang->deleted_by = Auth::id();
		$gudang->save();
		$gudang->delete();

		$text = 'menghapus '.$this->title;//.' '.$gudang->what;
		$this->log($request, $text, ['gudang.id' => $gudang->id]);
		return back()->with('message_success', 'Gudang berhasil dihapus!');
	}

}
