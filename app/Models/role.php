<?php
// app/Models/Role.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'role';
    protected $primaryKey = 'id_role';
    protected $fillable = ['nama', 'deskripsi'];

    public function admin()
    {
        return $this->hasMany(Admin::class, 'id_role');
    }
}