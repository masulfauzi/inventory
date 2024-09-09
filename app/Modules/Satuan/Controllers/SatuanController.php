<?php
namespace App\Modules\Satuan\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Satuan\Models\Satuan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SatuanController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Satuan";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Satuan::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Satuan::satuan', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'satuan' => ['Satuan', Form::text("satuan", old("satuan"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Satuan::satuan_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'satuan' => 'required',
			
		]);

		$satuan = new Satuan();
		$satuan->satuan = $request->input("satuan");
		
		$satuan->created_by = Auth::id();
		$satuan->save();

		$text = 'membuat '.$this->title; //' baru '.$satuan->what;
		$this->log($request, $text, ['satuan.id' => $satuan->id]);
		return redirect()->route('satuan.index')->with('message_success', 'Satuan berhasil ditambahkan!');
	}

	public function show(Request $request, Satuan $satuan)
	{
		$data['satuan'] = $satuan;

		$text = 'melihat detail '.$this->title;//.' '.$satuan->what;
		$this->log($request, $text, ['satuan.id' => $satuan->id]);
		return view('Satuan::satuan_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Satuan $satuan)
	{
		$data['satuan'] = $satuan;

		
		$data['forms'] = array(
			'satuan' => ['Satuan', Form::text("satuan", $satuan->satuan, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "satuan"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$satuan->what;
		$this->log($request, $text, ['satuan.id' => $satuan->id]);
		return view('Satuan::satuan_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'satuan' => 'required',
			
		]);
		
		$satuan = Satuan::find($id);
		$satuan->satuan = $request->input("satuan");
		
		$satuan->updated_by = Auth::id();
		$satuan->save();


		$text = 'mengedit '.$this->title;//.' '.$satuan->what;
		$this->log($request, $text, ['satuan.id' => $satuan->id]);
		return redirect()->route('satuan.index')->with('message_success', 'Satuan berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$satuan = Satuan::find($id);
		$satuan->deleted_by = Auth::id();
		$satuan->save();
		$satuan->delete();

		$text = 'menghapus '.$this->title;//.' '.$satuan->what;
		$this->log($request, $text, ['satuan.id' => $satuan->id]);
		return back()->with('message_success', 'Satuan berhasil dihapus!');
	}

}
