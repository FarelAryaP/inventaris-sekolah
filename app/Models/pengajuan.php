<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengajuan extends Model
{
    protected $primaryKey = 'id_pengajuan';
    protected $fillable = ['nisn','id_barang','jumlah','tgl_pengajuan','tgl_mulai','tgl_selesai','status','id_admin'];

    public function user() {
        return $this->belongsTo(User::class, 'nisn');
    }

    public function barang() {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function admin() {
        return $this->belongsTo(Admin::class, 'id_admin');
    }

    public function detailPeminjaman() {
        return $this->hasOne(detail_peminjaman::class, 'id_pengajuan');
    }
}
