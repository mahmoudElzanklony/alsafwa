<?php

namespace App\Http\Controllers;

use App\Http\Requests\privillageinfo;
use App\Models\Documents;
use App\Models\Privillage_data;
use App\Models\Services;
use App\Models\Services_Requests;
use Illuminate\Http\Request;
use App\Http\Traits\output_messages;
use Inertia\Inertia;

class PrivillageInfoController extends Controller
{
    //
    use output_messages;
    public function index(){
        $service = Services::query()->where('type','ترخيص')->first();
        $data = $this->detectDataShared($service , Privillage_data::first() , request('id') ?? '');
        return Inertia::render('privillage_data',[
            'privillage_data'=>$data,
            'type'=>'ترخيص',
        ]);
    }
    public function save(privillageinfo $privillageinfo){
        $data = $privillageinfo->validated();


        $service_data = Privillage_data::query()->updateOrCreate([
            'id'=>request()->has('id') ? request('id'):null
        ],$data);

        $service_request_data = Services_Requests::query()->find($data['service_request_id']);
        $service = Services::query()->find($service_request_data->service_id);
        $data_output = $this->detectDataShared($service , Privillage_data::first() , request('Uid') ?? '');

        return $this->success_output($data_output);
    }
}
