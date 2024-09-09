<?php

namespace App\Modules\BarangGudang\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Barang\Models\Barang;
use App\Modules\Gudang\Models\Gudang;


class BarangGudang extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
	protected $table      = 'barang_gudang';
	protected $fillable   = ['*'];	

	public function barang(){
		return $this->belongsTo(Barang::class,"id_barang","id");
	}
public function gudang(){
		return $this->belongsTo(Gudang::class,"id_gudang","id");
	}

}
