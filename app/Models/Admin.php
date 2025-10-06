<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    protected $fillable = ['username', 'nama', 'password', 'id_role'];
    protected $hidden = ['password'];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_admin');
    }
    
    public function getAuthIdentifierName()
    {
    return 'username';
    }

}