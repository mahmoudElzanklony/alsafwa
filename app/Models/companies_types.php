<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class companies_types extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['name','color'];

    protected $dates = ['deleted_at'];

}
