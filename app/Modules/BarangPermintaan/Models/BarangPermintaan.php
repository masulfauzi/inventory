<?php

namespace App\Modules\BarangPermintaan\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Permintaan\Models\Permintaan;
use App\Modules\BarangGudang\Models\BarangGudang;


class BarangPermintaan extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
	protected $table      = 'barang_permintaan';
	protected $fillable   = ['*'];	

	public function permintaan(){
		return $this->belongsTo(Permintaan::class,"id_permintaan","id");
	}
public function barangGudang(){
		return $this->belongsTo(BarangGudang::class,"id_barang_gudang","id");
	}

}
