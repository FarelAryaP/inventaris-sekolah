<?php
// app/Models/Pengajuan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengajuan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengajuan';
    protected $primaryKey = 'id_pengajuan';
    protected $fillable = [
        'nisn', 'id_barang', 'jumlah', 'tgl_pengajuan',
        'tgl_mulai', 'tgl_selesai', 'status', 'id_admin'
    ];
    protected $dates = ['tgl_pengajuan', 'tgl_mulai', 'tgl_selesai'];

    public function user()
    {
        return $this->belongsTo(User::class, 'nisn', 'nisn');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }

    public function detailPeminjaman()
    {
        return $this->hasOne(detail_peminjaman::class, 'id_pengajuan');
    }

    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 0: return 'Pending';
            case 1: return 'Approved';
            case 2: return 'Rejected';
            default: return 'Unknown';
        }
    }
}