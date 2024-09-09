<?php
namespace App\Modules\Kategori\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Kategori\Models\Kategori;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Kategori";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Kategori::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Kategori::kategori', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'kategori' => ['Kategori', Form::text("kategori", old("kategori"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Kategori::kategori_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'kategori' => 'required',
			
		]);

		$kategori = new Kategori();
		$kategori->kategori = $request->input("kategori");
		
		$kategori->created_by = Auth::id();
		$kategori->save();

		$text = 'membuat '.$this->title; //' baru '.$kategori->what;
		$this->log($request, $text, ['kategori.id' => $kategori->id]);
		return redirect()->route('kategori.index')->with('message_success', 'Kategori berhasil ditambahkan!');
	}

	public function show(Request $request, Kategori $kategori)
	{
		$data['kategori'] = $kategori;

		$text = 'melihat detail '.$this->title;//.' '.$kategori->what;
		$this->log($request, $text, ['kategori.id' => $kategori->id]);
		return view('Kategori::kategori_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Kategori $kategori)
	{
		$data['kategori'] = $kategori;

		
		$data['forms'] = array(
			'kategori' => ['Kategori', Form::text("kategori", $kategori->kategori, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "kategori"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$kategori->what;
		$this->log($request, $text, ['kategori.id' => $kategori->id]);
		return view('Kategori::kategori_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'kategori' => 'required',
			
		]);
		
		$kategori = Kategori::find($id);
		$kategori->kategori = $request->input("kategori");
		
		$kategori->updated_by = Auth::id();
		$kategori->save();


		$text = 'mengedit '.$this->title;//.' '.$kategori->what;
		$this->log($request, $text, ['kategori.id' => $kategori->id]);
		return redirect()->route('kategori.index')->with('message_success', 'Kategori berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$kategori = Kategori::find($id);
		$kategori->deleted_by = Auth::id();
		$kategori->save();
		$kategori->delete();

		$text = 'menghapus '.$this->title;//.' '.$kategori->what;
		$this->log($request, $text, ['kategori.id' => $kategori->id]);
		return back()->with('message_success', 'Kategori berhasil dihapus!');
	}

}
