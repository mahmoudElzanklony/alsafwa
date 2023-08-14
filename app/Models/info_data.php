<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class info_data extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['user_id','company_id','country_id','exporter_id','item','bill_number','bill_value','ACID',
        'permission','number_container','destination_id','line','policy','vehicle','arrived','instructions_status',
        'allowed','lifting_status',
        'forty_six_number','request_number','statement_status','notes','exchange_date','matching_status'
        ,'weight','number_data','status'];

    public function company(){
        return $this->belongsTo(companies_types::class,'company_id')->withTrashed();
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }

    public function destination(){
        return $this->belongsTo(destinations::class,'destination_id');
    }
    public function country(){
        return $this->belongsTo(countries::class,'country_id');
    }
    public function exporter(){
        return $this->belongsTo(exporters::class,'exporter_id');
    }
}
