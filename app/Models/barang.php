<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    protected $primaryKey = 'id_barang';
    protected $fillable = ['nama_barang','jumlah','keterangan'];

    public function pengajuans() {
        return $this->hasMany(Pengajuan::class, 'id_barang');
    }
}
