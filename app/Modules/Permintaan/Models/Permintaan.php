<?php

namespace App\Modules\Permintaan\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Status\Models\Status;
use App\Modules\Users\Models\Users;


class Permintaan extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
	protected $table      = 'permintaan';
	protected $fillable   = ['*'];	

	public function status(){
		return $this->belongsTo(Status::class,"id_status","id");
	}
public function users(){
		return $this->belongsTo(Users::class,"id_user","id");
	}

}
