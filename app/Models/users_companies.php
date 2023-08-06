<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class users_companies extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id','company_id'];

    protected $dates = ['deleted_at'];

    public function company(){
        return $this->belongsTo(companies_types::class,'company_id')->withTrashed();
    }

}
