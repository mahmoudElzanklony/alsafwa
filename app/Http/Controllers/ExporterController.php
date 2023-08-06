<?php

namespace App\Http\Controllers;

use App\Models\companies_types;
use App\Models\exporters;
use App\Models\reports;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExporterController extends Controller
{
    //
    public function index(){
        $data = exporters::query()->get();
        return Inertia::render('exporters',[
            'data'=>$data
        ]);
    }

    public function save(){
        $data = request()->all();


        $exporter = exporters::query()->updateOrCreate([
            'id'=>request()->has('id') ? request('id'):null,
        ],$data);

        // make report
        if(request()->has('id')){
            $content = 'قام '.auth()->user()->name.' بالتعديل علي المصدر الذي رقمه هو  '.request('id');
        }else{
            $content = 'قام '.auth()->user()->name.' بأنشاء مصدر جديد الذي رقمه هو  '.$exporter->id;
        }
        reports::query()->create([
            'user_id'=>auth()->user()->id,
            'content'=>$content
        ]);

        return response()->json(['success'=>exporters::query()->get()]);
    }

}
