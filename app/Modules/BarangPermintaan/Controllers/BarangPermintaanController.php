<?php
namespace App\Modules\BarangPermintaan\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\BarangPermintaan\Models\BarangPermintaan;
use App\Modules\Permintaan\Models\Permintaan;
use App\Modules\BarangGudang\Models\BarangGudang;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BarangPermintaanController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Barang Permintaan";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = BarangPermintaan::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('BarangPermintaan::barangpermintaan', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_permintaan = Permintaan::all()->pluck('id_status','id');
		$ref_barang_gudang = BarangGudang::all()->pluck('id_barang','id');
		
		$data['forms'] = array(
			'id_permintaan' => ['Permintaan', Form::select("id_permintaan", $ref_permintaan, null, ["class" => "form-control select2"]) ],
			'id_barang_gudang' => ['Barang Gudang', Form::select("id_barang_gudang", $ref_barang_gudang, null, ["class" => "form-control select2"]) ],
			'permintaan' => ['Permintaan', Form::text("permintaan", old("permintaan"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'disetujui' => ['Disetujui', Form::text("disetujui", old("disetujui"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('BarangPermintaan::barangpermintaan_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_permintaan' => 'required',
			'id_barang_gudang' => 'required',
			'permintaan' => 'required',
			'disetujui' => 'required',
			
		]);

		$barangpermintaan = new BarangPermintaan();
		$barangpermintaan->id_permintaan = $request->input("id_permintaan");
		$barangpermintaan->id_barang_gudang = $request->input("id_barang_gudang");
		$barangpermintaan->permintaan = $request->input("permintaan");
		$barangpermintaan->disetujui = $request->input("disetujui");
		
		$barangpermintaan->created_by = Auth::id();
		$barangpermintaan->save();

		$text = 'membuat '.$this->title; //' baru '.$barangpermintaan->what;
		$this->log($request, $text, ['barangpermintaan.id' => $barangpermintaan->id]);
		return redirect()->route('barangpermintaan.index')->with('message_success', 'Barang Permintaan berhasil ditambahkan!');
	}

	public function show(Request $request, BarangPermintaan $barangpermintaan)
	{
		$data['barangpermintaan'] = $barangpermintaan;

		$text = 'melihat detail '.$this->title;//.' '.$barangpermintaan->what;
		$this->log($request, $text, ['barangpermintaan.id' => $barangpermintaan->id]);
		return view('BarangPermintaan::barangpermintaan_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, BarangPermintaan $barangpermintaan)
	{
		$data['barangpermintaan'] = $barangpermintaan;

		$ref_permintaan = Permintaan::all()->pluck('id_status','id');
		$ref_barang_gudang = BarangGudang::all()->pluck('id_barang','id');
		
		$data['forms'] = array(
			'id_permintaan' => ['Permintaan', Form::select("id_permintaan", $ref_permintaan, null, ["class" => "form-control select2"]) ],
			'id_barang_gudang' => ['Barang Gudang', Form::select("id_barang_gudang", $ref_barang_gudang, null, ["class" => "form-control select2"]) ],
			'permintaan' => ['Permintaan', Form::text("permintaan", $barangpermintaan->permintaan, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "permintaan"]) ],
			'disetujui' => ['Disetujui', Form::text("disetujui", $barangpermintaan->disetujui, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "disetujui"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$barangpermintaan->what;
		$this->log($request, $text, ['barangpermintaan.id' => $barangpermintaan->id]);
		return view('BarangPermintaan::barangpermintaan_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_permintaan' => 'required',
			'id_barang_gudang' => 'required',
			'permintaan' => 'required',
			'disetujui' => 'required',
			
		]);
		
		$barangpermintaan = BarangPermintaan::find($id);
		$barangpermintaan->id_permintaan = $request->input("id_permintaan");
		$barangpermintaan->id_barang_gudang = $request->input("id_barang_gudang");
		$barangpermintaan->permintaan = $request->input("permintaan");
		$barangpermintaan->disetujui = $request->input("disetujui");
		
		$barangpermintaan->updated_by = Auth::id();
		$barangpermintaan->save();


		$text = 'mengedit '.$this->title;//.' '.$barangpermintaan->what;
		$this->log($request, $text, ['barangpermintaan.id' => $barangpermintaan->id]);
		return redirect()->route('barangpermintaan.index')->with('message_success', 'Barang Permintaan berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$barangpermintaan = BarangPermintaan::find($id);
		$barangpermintaan->deleted_by = Auth::id();
		$barangpermintaan->save();
		$barangpermintaan->delete();

		$text = 'menghapus '.$this->title;//.' '.$barangpermintaan->what;
		$this->log($request, $text, ['barangpermintaan.id' => $barangpermintaan->id]);
		return back()->with('message_success', 'Barang Permintaan berhasil dihapus!');
	}

}
