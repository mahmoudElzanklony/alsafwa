<?php

namespace App\Http\Controllers;

use App\Models\companies_types;
use App\Models\info_data;
use App\Models\Services_Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Traits\output_messages;

class ChartsController extends Controller
{
    //

    use output_messages;

    public function index(){

        for($i = 1; $i < 13; $i++) {
            $data[$i] = info_data::query()
                ->whereMonth('created_at', $i)
                ->whereYear('created_at',Date('Y'))
                ->select('id','created_at')->count();
        }
        $companines = companies_types::query()->get();
        return Inertia::render('charts_data',[
            'filter_data'=>$data,
            'companies'=>$companines
        ]);
    }

    public function filter(){
        for($i = 1; $i < 13; $i++) {
            $data[$i] = info_data::query()
                ->whereMonth('created_at', $i)
                ->whereYear('created_at',request('year'))
                ->where('status','=',request()->has('status') ? request('status'):0)
                ->when(request()->has('company_id'),function ($e){
                    $e->where('company_id','=',request('company_id'));
                })
                ->select('id','created_at')->count();
        }
        return response()->json($data);

    }
}
