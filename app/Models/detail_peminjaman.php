<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detail_peminjaman extends Model
{
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = ['id_pengajuan','tgl_mulai','tgl_selesai','status'];

    public function pengajuan() {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan');
    }
}
