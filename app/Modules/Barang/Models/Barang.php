<?php

namespace App\Modules\Barang\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Kategori\Models\Kategori;
use App\Modules\Satuan\Models\Satuan;


class Barang extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
	protected $table      = 'barang';
	protected $fillable   = ['*'];	

	public function kategori(){
		return $this->belongsTo(Kategori::class,"id_kategori","id");
	}
public function satuan(){
		return $this->belongsTo(Satuan::class,"id_satuan","id");
	}

}
