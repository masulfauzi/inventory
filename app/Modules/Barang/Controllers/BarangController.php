<?php
namespace App\Modules\Barang\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Barang\Models\Barang;
use App\Modules\Kategori\Models\Kategori;
use App\Modules\Satuan\Models\Satuan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Barang";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Barang::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Barang::barang', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_kategori = Kategori::all()->pluck('kategori','id');
		$ref_satuan = Satuan::all()->pluck('satuan','id');
		
		$data['forms'] = array(
			'id_kategori' => ['Kategori', Form::select("id_kategori", $ref_kategori, null, ["class" => "form-control select2"]) ],
			'id_satuan' => ['Satuan', Form::select("id_satuan", $ref_satuan, null, ["class" => "form-control select2"]) ],
			'nama_barang' => ['Nama Barang', Form::text("nama_barang", old("nama_barang"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Barang::barang_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_kategori' => 'required',
			'id_satuan' => 'required',
			'nama_barang' => 'required',
			
		]);

		$barang = new Barang();
		$barang->id_kategori = $request->input("id_kategori");
		$barang->id_satuan = $request->input("id_satuan");
		$barang->nama_barang = $request->input("nama_barang");
		
		$barang->created_by = Auth::id();
		$barang->save();

		$text = 'membuat '.$this->title; //' baru '.$barang->what;
		$this->log($request, $text, ['barang.id' => $barang->id]);
		return redirect()->route('barang.index')->with('message_success', 'Barang berhasil ditambahkan!');
	}

	public function show(Request $request, Barang $barang)
	{
		$data['barang'] = $barang;

		$text = 'melihat detail '.$this->title;//.' '.$barang->what;
		$this->log($request, $text, ['barang.id' => $barang->id]);
		return view('Barang::barang_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Barang $barang)
	{
		$data['barang'] = $barang;

		$ref_kategori = Kategori::all()->pluck('kategori','id');
		$ref_satuan = Satuan::all()->pluck('satuan','id');
		
		$data['forms'] = array(
			'id_kategori' => ['Kategori', Form::select("id_kategori", $ref_kategori, null, ["class" => "form-control select2"]) ],
			'id_satuan' => ['Satuan', Form::select("id_satuan", $ref_satuan, null, ["class" => "form-control select2"]) ],
			'nama_barang' => ['Nama Barang', Form::text("nama_barang", $barang->nama_barang, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nama_barang"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$barang->what;
		$this->log($request, $text, ['barang.id' => $barang->id]);
		return view('Barang::barang_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_kategori' => 'required',
			'id_satuan' => 'required',
			'nama_barang' => 'required',
			
		]);
		
		$barang = Barang::find($id);
		$barang->id_kategori = $request->input("id_kategori");
		$barang->id_satuan = $request->input("id_satuan");
		$barang->nama_barang = $request->input("nama_barang");
		
		$barang->updated_by = Auth::id();
		$barang->save();


		$text = 'mengedit '.$this->title;//.' '.$barang->what;
		$this->log($request, $text, ['barang.id' => $barang->id]);
		return redirect()->route('barang.index')->with('message_success', 'Barang berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$barang = Barang::find($id);
		$barang->deleted_by = Auth::id();
		$barang->save();
		$barang->delete();

		$text = 'menghapus '.$this->title;//.' '.$barang->what;
		$this->log($request, $text, ['barang.id' => $barang->id]);
		return back()->with('message_success', 'Barang berhasil dihapus!');
	}

}
