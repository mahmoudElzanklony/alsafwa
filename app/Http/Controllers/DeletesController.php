<?php

namespace App\Http\Controllers;

use App\Models\companies_types;
use App\Models\info_data;
use App\Models\reports;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeletesController extends Controller
{
    //
    public function index(){
        if(auth()->user()->type != 'admin') {
            return  redirect('/');
        }
        if(request()->has('type')){
            if(request('type') == 'users'){
                $data = User::onlyTrashed()->get();
            }else if(request('type') == 'branches'){
                $data = companies_types::onlyTrashed()->get();
            }else if(request('type') == 'info'){
                $data = info_data::with('user','company')->has('company')->onlyTrashed()->get();
            }else{
                return redirect('/');
            }
            return Inertia::render('deletes_data', [
                'data' =>$data,
            ]);
        }else {
            return Inertia::render('deletes', [
                'employees' => User::onlyTrashed()->count(),
                'companies' => companies_types::onlyTrashed()->count(),
                'info_data' => info_data::onlyTrashed()->count(),
            ]);
        }
    }
}
