<?php

namespace App\Modules\Transaksi\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\BarangGudang\Models\BarangGudang;


class Transaksi extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
	protected $table      = 'transaksi';
	protected $fillable   = ['*'];	

	public function barangGudang(){
		return $this->belongsTo(BarangGudang::class,"id_barang_gudang","id");
	}

}
