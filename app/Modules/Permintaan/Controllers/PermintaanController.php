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
use App\Modules\Barang\Models\Barang;
use App\Modules\BarangGudang\Models\BarangGudang;
use App\Modules\BarangPermintaan\Models\BarangPermintaan;
use App\Modules\Transaksi\Models\Transaksi;
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
		// dd(session('keranjang'));
		// $ref_users = Users::all()->pluck('name','id');
		// $ref_status = Status::all()->pluck('status_permintaan','id');
		// $ref_status->prepend('-PILIH SALAH SATU-', '');
		$data['keranjang'] = session('keranjang');

		$barang_gudang = BarangGudang::select('barang_gudang.id', 'b.nama_barang')
										->join('barang as b', 'barang_gudang.id_barang', '=', 'b.id')
										->where('barang_gudang.id_gudang', session('active_gudang')['id'])
										->get()->pluck('nama_barang', 'id');
		$barang_gudang->prepend('-PILIH SALAH SATU-', '');

		// dd($barang_gudang);

		
		$data['forms'] = array(
			'id_barang_gudang' => ['Nama Barang', Form::select("id_barang_gudang", $barang_gudang, null, ["class" => "form-control select2", "required"]) ],
			'jumlah' => ['Jumlah', Form::number("jumlah", old('jumlah'), ["class" => "form-control", "min" => 1, "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Permintaan::permintaan_create', array_merge($data, ['title' => $this->title]));
	}

	public function store_keranjang(Request $request)
	{
		$barang = BarangGudang::find($request->input('id_barang_gudang'));
		$data_keranjang = session('keranjang');

		$data_keranjang = collect($data_keranjang);
		
		$cek_data = $data_keranjang->where('id_barang_gudang', $request->input('id_barang_gudang'));
		// dd($cek_data);

		if (count($cek_data) > 0) {
			$new_keranjang = [

			];
			foreach($data_keranjang as $item_keranjang) {
				if ($item_keranjang['id_barang_gudang'] == $request->input('id_barang_gudang')) {
				    $data = [
						'id_barang_gudang'	=> $request->input('id_barang_gudang'),
						'permintaan'		=> $request->input('jumlah') + $item_keranjang['permintaan'],
						'disetujui'		=> $request->input('jumlah') + $item_keranjang['disetujui'],
						'nama_barang'	=> $barang->barang->nama_barang
					];
				}
				else {
					$data = [
						'id_barang_gudang'	=> $item_keranjang['id_barang_gudang'],
						'permintaan'		=> $item_keranjang['permintaan'],
						'disetujui'		=> $item_keranjang['disetujui'],
						'nama_barang'	=> $item_keranjang['nama_barang'],
					];
				}
				array_push($new_keranjang, $data);
			}
			session(['keranjang' => $new_keranjang]);
		}
		else {
			$keranjang = [
				'id_barang_gudang'	=> $request->input('id_barang_gudang'),
				'permintaan'		=> $request->input('jumlah'),
				'disetujui'		=> $request->input('jumlah'),
				'nama_barang'	=> $barang->barang->nama_barang
			];
	
			session()->push('keranjang', $keranjang);
		}
		return redirect()->back()->with('message_success', 'Data berhasil disimpan di keranjang.');
	}

	public function hapus_keranjang(Request $request, $id) {
		$keranjang = session('keranjang');
		$keranjang = collect($keranjang);
		$cek_data = $keranjang->where('id_barang_gudang', $id);
		// dd($cek_data);
		$new_keranjang = [

		];
		foreach($keranjang as $item_keranjang) {
			if ($item_keranjang['id_barang_gudang'] == $id) {
				
			}
			else {
				$data = [
					'id_barang_gudang'	=> $item_keranjang['id_barang_gudang'],
					'permintaan'		=> $item_keranjang['permintaan'],
					'disetujui'		=> $item_keranjang['disetujui'],
					'nama_barang'	=> $item_keranjang['nama_barang'],
				];
				array_push($new_keranjang, $data);
			}
		}
		session(['keranjang' => $new_keranjang]);
		return redirect()->back()->with('message_success', 'Data berhasil dihapus.');
	}

	public function detail_permintaan(Request $request, Permintaan $permintaan) {
		$data['permintaan'] = $permintaan;
		$data['barang_permintaan'] = BarangPermintaan::select('barang_permintaan.*', 'bg.stok')
										->join('barang_gudang as bg', 'barang_permintaan.id_barang_gudang', '=', 'bg.id')
										->whereIdPermintaan($permintaan->id)->get();
		// dd($data);


		$text = 'melihat detail '.$this->title;//.' '.$permintaan->what;
		$this->log($request, $text, ['permintaan.id' => $permintaan->id]);
		return view('Permintaan::permintaan_detail_user', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		// $this->validate($request, [
		// 	'id_status' => 'required',
		// 	'id_user' => 'required',
			
		// ]);

		$keranjang = session('keranjang');
		// dd($keranjang);

		$status = Status::whereUrutan(1)->first();

		$permintaan = new Permintaan();
		$permintaan->id_status = $status->id;
		$permintaan->id_user = Auth::user()->id;
		
		$permintaan->created_by = Auth::id();
		$permintaan->save();

		for($i = 0; $i < count($keranjang); $i++)
		{
			$barang_permintaan = new BarangPermintaan();
			$barang_permintaan->id_permintaan = $permintaan->id;
			$barang_permintaan->id_barang_gudang = $keranjang[$i]['id_barang_gudang'];
			$barang_permintaan->permintaan = $keranjang[$i]['permintaan'];
			$barang_permintaan->disetujui = $keranjang[$i]['permintaan'];

            $barang_permintaan->created_by = Auth::id();
			$barang_permintaan->save();
		}


		$text = 'membuat '.$this->title; //' baru '.$permintaan->what;
		$this->log($request, $text, ['permintaan.id' => $permintaan->id]);
		return redirect()->route('permintaan.index')->with('message_success', 'Permintaan berhasil ditambahkan!');
	}

	public function permintaan_user(Request $request)
	{
		$query = Permintaan::orderBy('created_at', 'desc');
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Permintaan::permintaan_user', array_merge($data, ['title' => $this->title]));
	}

	public function show(Request $request, Permintaan $permintaan)
	{
		$data['permintaan'] = $permintaan;
		$data['barang_permintaan'] = BarangPermintaan::select('barang_permintaan.*', 'bg.stok')
										->join('barang_gudang as bg', 'barang_permintaan.id_barang_gudang', '=', 'bg.id')
										->whereIdPermintaan($permintaan->id)->get();
		// dd($data);


		$text = 'melihat detail '.$this->title;//.' '.$permintaan->what;
		$this->log($request, $text, ['permintaan.id' => $permintaan->id]);
		return view('Permintaan::permintaan_detail', array_merge($data, ['title' => $this->title]));
	}

	public function setujui_permintaan(Request $request)
	{
		for($i=0; $i<count($request->id_barang_permintaan); $i++)
		{
			$barang = BarangPermintaan::find($request->id_barang_permintaan[$i]);

			$barang->disetujui = $request->disetujui[$i];
			$barang->save();

			$barang_gudang = BarangGudang::find($barang->id_barang_gudang);

			$barang_gudang->stok -= $barang->disetujui;
			$barang_gudang->save();


			// dd($barang_gudang);

			$transaksi = new Transaksi();

			$transaksi->id_barang_gudang = $barang->id_barang_gudang;
			$transaksi->keluar = $barang->disetujui;
			$transaksi->tgl_transaksi = date('Y-m-d');
			$transaksi->created_at = date('Y-m-d H:i:s');
			$transaksi->created_by = Auth::user()->id;
			$transaksi->save();

			


			// dd($transaksi);
		}

		$status = Status::whereStatusPermintaan('Siap Diambil')->first();

		$permintaan = Permintaan::find($request->id_permintaan);
		$permintaan->id_status = $status->id;
		$permintaan->save();

		return redirect()->back()->with('message_success', 'Data Berhasil Disimpan');
	}

	public function selesaikan_permintaan(Request $request)
	{
		for($i=0; $i<count($request->id_barang_permintaan); $i++)
		{
			$barang = BarangPermintaan::find($request->id_barang_permintaan[$i]);

			$barang->disetujui = $request->disetujui[$i];
			$barang->save();

			$barang_gudang = BarangGudang::find($barang->id_barang_gudang);

			$barang_gudang->stok -= $barang->disetujui;
			$barang_gudang->save();


			// dd($barang_gudang);

			$transaksi = new Transaksi();

			$transaksi->id_barang_gudang = $barang->id_barang_gudang;
			$transaksi->keluar = $barang->disetujui;
			$transaksi->tgl_transaksi = date('Y-m-d');
			$transaksi->created_at = date('Y-m-d H:i:s');
			$transaksi->created_by = Auth::user()->id;
			$transaksi->save();

			


			// dd($transaksi);
		}

		$status = Status::whereStatusPermintaan('Selesai')->first();

		$permintaan = Permintaan::find($request->id_permintaan);
		$permintaan->id_status = $status->id;
		$permintaan->save();

		return redirect()->back()->with('message_success', 'Pesanan Berhasil Diselesaikan');
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
