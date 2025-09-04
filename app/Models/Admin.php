<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $primaryKey = 'id_admin';
    protected $fillable = ['username','nama','password','id_role'];

    public function role() {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function pengajuans() {
        return $this->hasMany(Pengajuan::class, 'id_admin');
    }
}
