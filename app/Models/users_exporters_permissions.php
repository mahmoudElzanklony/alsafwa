<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users_exporters_permissions extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','exporter_id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function exporter(){
        return $this->belongsTo(exporters::class,'exporter_id');
    }
}
