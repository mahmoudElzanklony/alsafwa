<?php

namespace App\Http\Controllers;

use App\Models\destinations;
use App\Models\exporters;
use App\Models\reports;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DestinationsController extends Controller
{
    //
    //
    public function index(){
        $data = destinations::query()->get();
        return Inertia::render('destinations',[
            'data'=>$data
        ]);
    }

    public function save(){
        $data = request()->all();


        $destination = destinations::query()->updateOrCreate([
            'id'=>request()->has('id') ? request('id'):null,
        ],$data);

        // make report
        if(request()->has('id')){
            $content = 'قام '.auth()->user()->name.' بالتعديل علي وجهه الذي رقمه هو  '.request('id');
        }else{
            $content = 'قام '.auth()->user()->name.' بأنشاء وجهه جديدة الذي رقمه هو  '.$destination->id;
        }
        reports::query()->create([
            'user_id'=>auth()->user()->id,
            'content'=>$content
        ]);

        return response()->json(['success'=>destinations::query()->get()]);
    }

}
