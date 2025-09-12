<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user';
    protected $primaryKey = 'nisn';
    protected $fillable = ['nama', 'kelas'];

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'nisn', 'nisn');
    }
}