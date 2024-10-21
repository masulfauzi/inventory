<?php

namespace App\Modules\UserGudang\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\User\Models\User;
use App\Modules\Gudang\Models\Gudang;


class UserGudang extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
	protected $table      = 'user_gudang';
	protected $fillable   = ['*'];	

	public function user(){
		return $this->belongsTo(User::class,"id_user","id");
	}
public function gudang(){
		return $this->belongsTo(Gudang::class,"id_gudang","id");
	}

}
