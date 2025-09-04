<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    protected $fillable = ['nama','deskripsi'];

    public function admins() {
        return $this->hasMany(Admin::class, 'id_role');
    }
}
