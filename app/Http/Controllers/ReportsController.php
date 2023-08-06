<?php

namespace App\Http\Controllers;

use App\Models\reports;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportsController extends Controller
{
    //
    public function index(){
        if(auth()->user()->type != 'admin') {
            return  redirect('/');
        }
        return Inertia::render('reports',[
            'data'=>reports::query()->with('user')->whereHas('user',function($user){
                $user->where('deleted_at','=',null);
            })->get()
        ]);
    }
}
