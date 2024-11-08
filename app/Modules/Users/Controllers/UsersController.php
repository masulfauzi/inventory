<?php
namespace App\Modules\Users\Controllers;

use Form;
use Illuminate\Http\Request;
use App\Modules\Role\Models\Role;
use App\Modules\Users\Models\Users;
use App\Http\Controllers\Controller;
use App\Modules\Gudang\Models\Gudang;
use App\Modules\UserGudang\Models\UserGudang;
use App\Modules\UserRole\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
	protected $title = "Users";
	public function index(Request $request)
	{
		$query = Users::with('roleuser');
		if($request->has('search')){
			$search = $request->get('search');
			$query->where('name', 'like', "%$search%")
					->orWhere('email', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();
		
		return view('Users::users', array_merge($data, ['title' => $this->title]));
	}

	public function create()
	{
		$roles = Role::all()->pluck('role', 'id');
		$gudang = Gudang::all()->pluck('nama_gudang', 'id');
		// die($gudang);
		$gudang->prepend('-PILIH SALAH SATU-','');
		$data['forms'] = array(
			'name' => ['Name', Form::text("name", old('name'), ["class" => "form-control","placeholder" => "", "required" => "required"])],
			'username' => ['Username', Form::text("username", old('username'), ["class" => "form-control","placeholder" => "", "required" => "required"])],
			'email' => ['Email', Form::text("email", old('email'), ["class" => "form-control","placeholder" => "", "required" => "required"])],
			'password' => ['Password', Form::password("password", ["class" => "form-control","placeholder" => "", "required" => "required"])],
			'no_hp' => ['No HP', Form::text("no_hp", old('no_hp'), ["class" => "form-control","placeholder" => "Contoh:628512345678", "required" => "required"])],
			'id_gudang' => ['Pilih Gudang', Form::select("id_gudang", $gudang, null,["class" => "form-control select2", "required" => "required"])],
			'roles' => ['Role', Form::select("roles[]", $roles, null, ["class" => "form-control multi-select2","placeholder" => "", "required" => "required"])],
		);
		return view('Users::form_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'username' => 'required|unique:users,username',
			'email' => 'required|email',
			'password' => 'required',
			'no_hp' => 'required',
			'id_gudang' => 'required',
			'roles' => 'required|array',
		]);

		$users = new Users();
		$users->name = $request->input("name");
		$users->username = $request->input("username");
		$users->email = $request->input("email");
		$users->password = bcrypt($request->input("password"));
		$users->identitas = $request->input("identitas");
		$users->created_by = Auth::id();
		$users->save();

		$user_gudang = new UserGudang();
		$user_gudang->id_user = $users->id;
		$user_gudang->id_gudang = $request->input("id_gudang");
		$user_gudang->created_by = Auth::id();
		$user_gudang->save();

		foreach ($request->get('roles') as $key => $value) {
			$ur = new UserRole();
			$ur->id_user = $users->id;
			$ur->id_role = $value;
			$ur->save();
		}

		return redirect()->route('users.index')->with('message_success', 'User berhasil ditambahkan!');
	}

	public function edit(Users $user)
	{
		$roles = Role::all()->pluck('role', 'id');
		$selected_roles = UserRole::where('id_user', $user->id)->get()->pluck('id_role');
		$data['selecteds'] = $selected_roles;
		$data['user'] = $user;
		$gudang = Gudang::all()->pluck('nama_gudang', 'id');


		$data['forms'] = array(
			'name' => ['Name', Form::text("name", $user->name, ["class" => "form-control","placeholder" => "", "required" => "required"])],
			'username' => ['Username', Form::text("username", $user->username, ["class" => "form-control","placeholder" => "", "required" => "required"])],
			'email' => ['Email', Form::text("email", $user->email, ["class" => "form-control","placeholder" => "", "required" => "required"])],
			'password' => ['Password', Form::password("password", ["class" => "form-control","placeholder" => "Kosongkan jika tidak ingin mengubah"])],
			'id_gudang' => ['Pilih Gudang', Form::select("id_gudang", $gudang, null,["class" => "form-control select2", "required" => "required"])],
			'roles' => ['Role', Form::select("roles[]", $roles, $selected_roles, ["class" => "form-control multi-select2","placeholder" => "", "required" => "required"])],
		);

		return view('Users::form_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$validation = array(
			'name' => 'required',
			'email' => 'required|email',
			'password' => 'nullable',
			'username' => 'required',
			'id_gudang' => 'required',
			'roles' => 'required|array',
		);
		$this->validate($request, $validation);
		
		$users = Users::find($id);
		$users->name = $request->input("name");
		$users->email = $request->input("email");
		$users->password = empty($request->input("password")) ? $users->password : bcrypt($request->input("password"));
		$users->username = $request->input("username");
		$users->identitas = $request->input("identitas");
		$users->updated_by = Auth::user()->id;
		$users->save();

		UserRole::where('id_user', $id)->delete();
		foreach ($request->get('roles') as $key => $value) {
			$ur = UserRole::withTrashed()->where('id_role', $value)->where('id_user', $id)->first();
			$ur = $ur ?? new UserRole();
			$ur->id_role = $value;
			$ur->id_user = $id;
			$ur->deleted_at = NULL;
			$ur->save();
		}

		$user_gudang = UserGudang::where('id_user', $users->id)->first();
		$user_gudang->id_gudang = $request->input("id_gudang");
		$user_gudang->updated_by = Auth::id();
		$user_gudang->save();

		return redirect()->route('users.index')->with('message_success', 'User berhasil diubah!');
	}

	public function destroy($id)
	{
		$user = Users::find($id);
		$user->deleted_by = Auth::id();
		$user->save();
		$user->delete();

		return back()->with('message_success', 'User berhasil dihapus!');
	}

}
