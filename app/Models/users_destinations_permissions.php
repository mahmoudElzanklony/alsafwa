<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users_destinations_permissions extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','destination_id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function destination(){
        return $this->belongsTo(destinations::class,'destination_id');
    }
}
