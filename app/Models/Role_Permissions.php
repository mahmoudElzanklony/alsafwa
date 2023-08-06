<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_Permissions extends Model
{
    use HasFactory;

    protected $fillable = ['role_id','permission_id'];

    public function role(){
        return $this->belongsTo(Roles::class);
    }

    public function permission(){
        return $this->belongsTo(Permissions::class);
    }
}
