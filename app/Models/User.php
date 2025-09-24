<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class User extends Authenticable
{
    use HasFactory, SoftDeletes;

    protected $table = 'user';
    protected $primaryKey = 'nisn';
    protected $fillable = ['nama', 'kelas', 'password'];

    protected $hidden = ['password'];

    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = Hash::make($password);
        }
    }

    public function getAuthIdentifierName()
    {
        return 'nisn';
    }

    public function getAuthIdentifier()
    {
        return $this->getAttribute('nisn');
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'nisn', 'nisn');
    }
}