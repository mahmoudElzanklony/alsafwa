<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function permissions(){
        return $this->belongsToMany(Permissions::class,Role_Permissions::class,'role_id','permission_id');
    }
}
