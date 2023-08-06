<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privillage_data extends Model
{
    use HasFactory;

    protected $table = 'privillage_datas';

    protected $fillable = ['service_request_id','transaction_num','start_date',
                           'board_review','export_status','end_date','receipt'];

    public function service_request(){
        return $this->belongsTo(Services_Requests::class,'service_request_id');
    }
}
