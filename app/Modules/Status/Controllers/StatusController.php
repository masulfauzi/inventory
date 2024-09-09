<?php
namespace App\Modules\Status\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Status\Models\Status;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Status";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Status::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Status::status', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'status_permintaan' => ['Status Permintaan', Form::text("status_permintaan", old("status_permintaan"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Status::status_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'status_permintaan' => 'required',
			
		]);

		$status = new Status();
		$status->status_permintaan = $request->input("status_permintaan");
		
		$status->created_by = Auth::id();
		$status->save();

		$text = 'membuat '.$this->title; //' baru '.$status->what;
		$this->log($request, $text, ['status.id' => $status->id]);
		return redirect()->route('status.index')->with('message_success', 'Status berhasil ditambahkan!');
	}

	public function show(Request $request, Status $status)
	{
		$data['status'] = $status;

		$text = 'melihat detail '.$this->title;//.' '.$status->what;
		$this->log($request, $text, ['status.id' => $status->id]);
		return view('Status::status_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Status $status)
	{
		$data['status'] = $status;

		
		$data['forms'] = array(
			'status_permintaan' => ['Status Permintaan', Form::text("status_permintaan", $status->status_permintaan, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "status_permintaan"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$status->what;
		$this->log($request, $text, ['status.id' => $status->id]);
		return view('Status::status_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'status_permintaan' => 'required',
			
		]);
		
		$status = Status::find($id);
		$status->status_permintaan = $request->input("status_permintaan");
		
		$status->updated_by = Auth::id();
		$status->save();


		$text = 'mengedit '.$this->title;//.' '.$status->what;
		$this->log($request, $text, ['status.id' => $status->id]);
		return redirect()->route('status.index')->with('message_success', 'Status berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$status = Status::find($id);
		$status->deleted_by = Auth::id();
		$status->save();
		$status->delete();

		$text = 'menghapus '.$this->title;//.' '.$status->what;
		$this->log($request, $text, ['status.id' => $status->id]);
		return back()->with('message_success', 'Status berhasil dihapus!');
	}

}
