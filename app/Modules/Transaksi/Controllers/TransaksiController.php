<?php
namespace App\Modules\Transaksi\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Transaksi\Models\Transaksi;
use App\Modules\BarangGudang\Models\BarangGudang;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Transaksi";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Transaksi::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Transaksi::transaksi', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_barang_gudang = BarangGudang::all()->pluck('id_barang','id');
		
		$data['forms'] = array(
			'id_barang_gudang' => ['Barang Gudang', Form::select("id_barang_gudang", $ref_barang_gudang, null, ["class" => "form-control select2"]) ],
			'masuk' => ['Masuk', Form::text("masuk", old("masuk"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'keluar' => ['Keluar', Form::text("keluar", old("keluar"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'tgl_transaksi' => ['Tgl Transaksi', Form::text("tgl_transaksi", old("tgl_transaksi"), ["class" => "form-control datepicker", "required" => "required"]) ],
			'bukti_transaksi' => ['Bukti Transaksi', Form::text("bukti_transaksi", old("bukti_transaksi"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Transaksi::transaksi_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_barang_gudang' => 'required',
			'masuk' => 'required',
			'keluar' => 'required',
			'tgl_transaksi' => 'required',
			'bukti_transaksi' => 'required',
			
		]);

		$transaksi = new Transaksi();
		$transaksi->id_barang_gudang = $request->input("id_barang_gudang");
		$transaksi->masuk = $request->input("masuk");
		$transaksi->keluar = $request->input("keluar");
		$transaksi->tgl_transaksi = $request->input("tgl_transaksi");
		$transaksi->bukti_transaksi = $request->input("bukti_transaksi");
		
		$transaksi->created_by = Auth::id();
		$transaksi->save();

		$text = 'membuat '.$this->title; //' baru '.$transaksi->what;
		$this->log($request, $text, ['transaksi.id' => $transaksi->id]);
		return redirect()->route('transaksi.index')->with('message_success', 'Transaksi berhasil ditambahkan!');
	}

	public function show(Request $request, Transaksi $transaksi)
	{
		$data['transaksi'] = $transaksi;

		$text = 'melihat detail '.$this->title;//.' '.$transaksi->what;
		$this->log($request, $text, ['transaksi.id' => $transaksi->id]);
		return view('Transaksi::transaksi_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Transaksi $transaksi)
	{
		$data['transaksi'] = $transaksi;

		$ref_barang_gudang = BarangGudang::all()->pluck('id_barang','id');
		
		$data['forms'] = array(
			'id_barang_gudang' => ['Barang Gudang', Form::select("id_barang_gudang", $ref_barang_gudang, null, ["class" => "form-control select2"]) ],
			'masuk' => ['Masuk', Form::text("masuk", $transaksi->masuk, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "masuk"]) ],
			'keluar' => ['Keluar', Form::text("keluar", $transaksi->keluar, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "keluar"]) ],
			'tgl_transaksi' => ['Tgl Transaksi', Form::text("tgl_transaksi", $transaksi->tgl_transaksi, ["class" => "form-control datepicker", "required" => "required", "id" => "tgl_transaksi"]) ],
			'bukti_transaksi' => ['Bukti Transaksi', Form::text("bukti_transaksi", $transaksi->bukti_transaksi, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "bukti_transaksi"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$transaksi->what;
		$this->log($request, $text, ['transaksi.id' => $transaksi->id]);
		return view('Transaksi::transaksi_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_barang_gudang' => 'required',
			'masuk' => 'required',
			'keluar' => 'required',
			'tgl_transaksi' => 'required',
			'bukti_transaksi' => 'required',
			
		]);
		
		$transaksi = Transaksi::find($id);
		$transaksi->id_barang_gudang = $request->input("id_barang_gudang");
		$transaksi->masuk = $request->input("masuk");
		$transaksi->keluar = $request->input("keluar");
		$transaksi->tgl_transaksi = $request->input("tgl_transaksi");
		$transaksi->bukti_transaksi = $request->input("bukti_transaksi");
		
		$transaksi->updated_by = Auth::id();
		$transaksi->save();


		$text = 'mengedit '.$this->title;//.' '.$transaksi->what;
		$this->log($request, $text, ['transaksi.id' => $transaksi->id]);
		return redirect()->route('transaksi.index')->with('message_success', 'Transaksi berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$transaksi = Transaksi::find($id);
		$transaksi->deleted_by = Auth::id();
		$transaksi->save();
		$transaksi->delete();

		$text = 'menghapus '.$this->title;//.' '.$transaksi->what;
		$this->log($request, $text, ['transaksi.id' => $transaksi->id]);
		return back()->with('message_success', 'Transaksi berhasil dihapus!');
	}

}
