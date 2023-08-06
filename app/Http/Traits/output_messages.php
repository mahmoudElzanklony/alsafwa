<?php
namespace App\Http\Traits;

use App\Models\Services;
use App\Models\Services_Requests;

trait output_messages{
    public function error_output($msg){
        return response()->json(['error_message'=>$msg]);
    }

    public function success_output($msg){
        return response()->json(['success'=>$msg]);
    }

    public function detectName($name){
        if($name == "licence"){
            $name = Services::query()->where('type','ترخيص')->first();
        }else if($name == "shops-licensing"){
            $name = Services::query()->where('name','ترخيص محلات')->first();
        }else if($name == "rationing"){
            $name = Services::query()->where('name','التقنين')->first();
        }else if($name == "internal-engineering"){
            $name = Services::query()->where('name','تصميم داخلي')->first();
        }else{
            return back();
        }
        return $name;
    }

    public function detectDataShared($name , $model , $urlID = ""){
        if($name->type == ''){

            $data = $model::query()->with(['service_request'=>function($e) use ($name , $urlID){
                $e->when($urlID != ""  , function ($c) use ($urlID){
                    $c->where('id',$urlID);
                })->with('service','client')->whereHas('service',function($query) use($name){
                    $query->where('id',$name->id);
                });
            }])->latest()->get();

        }else{
            $data = $model::query()->with(['service_request'=>function($e) use ($name , $urlID){
                $e->when($urlID != ""  , function ($c) use ($urlID){
                    $c->where('id',$urlID);
                })->with('service','client')->whereHas('service',function($query) {
                    $query->where('type', 'ترخيص');
                });
            }])->latest()->get();
        }
        $data =  $data->reject(function ($e){
            return $e->service_request == null;
        });
        return $data;
    }

    public function detectDataFilter($hasNot = "" , $cond = []){
        $data = Services_Requests::query()->with(['service'=>function($e) use ($cond){
            $e->when(sizeof($cond) > 0,function ($query) use ($cond){
                $query->whereIn($cond[0],$cond[1]);
            });
        },'client','documents'])->when($hasNot != "" , function ($e) use ($hasNot){
            $e->doesntHave($hasNot);
        })
            ->latest()->get();

        if(sizeof($cond) > 0 ){
            $data = $data->reject(function ($e){
                return $e->service == null;
            });
        }

        return $data;
    }
}
