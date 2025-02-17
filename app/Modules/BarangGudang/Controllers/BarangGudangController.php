<?php
namespace App\Modules\BarangGudang\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Barang\Models\Barang;

use App\Modules\Gudang\Models\Gudang;
use App\Modules\Transaksi\Models\Transaksi;
use App\Modules\BarangGudang\Models\BarangGudang;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangGudangController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Barang Gudang";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = BarangGudang::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('BarangGudang::baranggudang', array_merge($data, ['title' => $this->title]));
	}

	public function laporan_barang(Request $request) 
	{
		$query = BarangGudang::query();
		$data['data'] = $query->paginate(10)->withQueryString();


		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		// return view('', array_merge($data, ['title' => $this->title]));
		$pdf = Pdf::loadView('BarangGudang::laporan_barang', $data);
    return $pdf->download('invoice.pdf');
	}

	public function create(Request $request)
	{
		$ref_gudang = Gudang::all()->pluck('nama_gudang','id');
		$ref_gudang->prepend('-PILIH SALAH SATU-', '');
		$ref_barang = Barang::all()->pluck('nama_barang','id');
		$ref_barang->prepend('-PILIH SALAH SATU-', '');

		
		$data['forms'] = array(
			'id_gudang' => ['', Form::hidden("id_gudang", session('active_gudang')['id']) ],
			'id_barang' => ['Barang', Form::select("id_barang", $ref_barang, null, ["class" => "form-control select2"]) ],
			'stok' => ['Stok', Form::text("stok", old("stok"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('BarangGudang::baranggudang_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_gudang' => 'required',
			'id_barang' => 'required',
			'stok' => 'required',
			
		]);
		$cek_barang = BarangGudang::where('id_barang', $request->input('id_barang'))->first();
		// dd($baranggudang);

		if ($cek_barang) {

		$baranggudang = BarangGudang::find($cek_barang->id);
		$baranggudang->stok = $request->input("stok") + $baranggudang->stok;
		
		$baranggudang->updated_by = Auth::id();
		$baranggudang->save();

		}
		else {

		$baranggudang = new BarangGudang();
		$baranggudang->id_gudang = $request->input("id_gudang");
		$baranggudang->id_barang = $request->input("id_barang");
		$baranggudang->stok = $request->input("stok");
		
		$baranggudang->created_by = Auth::id();
		$baranggudang->save();

		}

		

		$text = 'membuat '.$this->title; //' baru '.$baranggudang->what;
		// $this->log($request, $text, ['baranggudang.id' => $baranggudang->id]);
		return redirect()->route('baranggudang.index')->with('message_success', 'Barang Gudang berhasil ditambahkan!');
	}


	public function show(Request $request, BarangGudang $baranggudang)
	{
		$data['baranggudang'] = $baranggudang;
		$data['transaksi'] = Transaksi::where('id_barang_gudang', $baranggudang->id)->paginate(10)->withQueryString();

		$text = 'melihat detail '.$this->title;//.' '.$baranggudang->what;
		$this->log($request, $text, ['baranggudang.id' => $baranggudang->id]);
		return view('BarangGudang::baranggudang_detail', array_merge($data, ['title' => $this->title]));
	}

	public function laporan_transaksi(Request $request, BarangGudang $baranggudang) 
	{
		// $query = Transaksi::query();
		// $data['laporan'] = $query->paginate(10)->withQueryString();

		$data['baranggudang'] = $baranggudang;
		$data['laporan'] = Transaksi::where('id_barang_gudang', $baranggudang->id)->get();
		$this->log($request, 'melihat laporan '.$this->title);
		// return view('BarangGudang::laporan_transaksi', array_merge($data, ['title' => $this->title]));
		$pdf = Pdf::loadView('BarangGudang::laporan_transaksi', $data);
    	return $pdf->download('invoice.pdf');
	}

	public function edit(Request $request, BarangGudang $baranggudang)
	{
		$data['baranggudang'] = $baranggudang;

		$ref_gudang = Gudang::all()->pluck('created_at','id');
		$ref_gudang->prepend('-PILIH SALAH SATU-', '');
		$ref_barang = Barang::all()->pluck('created_by','id');
		$ref_barang->prepend('-PILIH SALAH SATU-', '');
		
		$data['forms'] = array(
			'id_gudang' => ['Gudang', Form::select("id_gudang", $ref_gudang, null, ["class" => "form-control select2"]) ],
			'id_barang' => ['Barang', Form::select("id_barang", $ref_barang, null, ["class" => "form-control select2"]) ],
			'stok' => ['Stok', Form::text("stok", $baranggudang->stok, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "stok"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$baranggudang->what;
		$this->log($request, $text, ['baranggudang.id' => $baranggudang->id]);
		return view('BarangGudang::baranggudang_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_gudang' => 'required',
			'id_barang' => 'required',
			'stok' => 'required',
			
		]);
		
		$baranggudang = BarangGudang::find($id);
		$baranggudang->id_barang = $request->input("id_barang");
		$baranggudang->id_gudang = $request->input("id_gudang");
		$baranggudang->stok = $request->input("stok");
		
		$baranggudang->updated_by = Auth::id();
		$baranggudang->save();


		$text = 'mengedit '.$this->title;//.' '.$baranggudang->what;
		$this->log($request, $text, ['baranggudang.id' => $baranggudang->id]);
		return redirect()->route('baranggudang.index')->with('message_success', 'Barang Gudang berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$baranggudang = BarangGudang::find($id);
		$baranggudang->deleted_by = Auth::id();
		$baranggudang->save();
		$baranggudang->delete();

		$text = 'menghapus '.$this->title;//.' '.$baranggudang->what;
		$this->log($request, $text, ['baranggudang.id' => $baranggudang->id]);
		return back()->with('message_success', 'Barang Gudang berhasil dihapus!');
	}

}
