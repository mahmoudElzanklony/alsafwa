<?php

namespace App\Http\Controllers;

use App\Models\countries;
use App\Models\exporters;
use App\Models\reports;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CountriesController extends Controller
{
    //
    //
    public function index(){
        $data = countries::query()->get();
        return Inertia::render('countries',[
            'data'=>$data
        ]);
    }

    public function save(){
        $data = request()->all();


        $country = countries::query()->updateOrCreate([
            'id'=>request()->has('id') ? request('id'):null,
        ],$data);

        // make report
        if(request()->has('id')){
            $content = 'قام '.auth()->user()->name.' بالتعديل علي المنشأ الذي رقمه هو  '.request('id');
        }else{
            $content = 'قام '.auth()->user()->name.' بأنشاء منشأ جديد الذي رقمه هو  '.$country->id;
        }
        reports::query()->create([
            'user_id'=>auth()->user()->id,
            'content'=>$content
        ]);

        return response()->json(['success'=>countries::query()->get()]);
    }

}
