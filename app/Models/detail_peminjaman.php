<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class detail_peminjaman extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = [
        'id_pengajuan', 'tgl_mulai', 'tgl_selesai', 'status'
    ];
    protected $dates = ['tgl_mulai', 'tgl_selesai'];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan');
    }

    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 0: return 'Dipinjam';
            case 1: return 'Dikembalikan';
            case 2: return 'Hilang';
            default: return 'Unknown';
        }
    }
}