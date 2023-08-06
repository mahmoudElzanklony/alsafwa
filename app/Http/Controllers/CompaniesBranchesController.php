<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users;
use App\Models\companies_types;
use App\Models\reports;
use App\Models\User;
use App\Models\users_companies;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompaniesBranchesController extends Controller
{
    //
    public function index(){
        if(auth()->user()->type == 'admin') {
            $branches = companies_types::query()->get();
            return Inertia::render('companies_branches', [
                'branches' => $branches
            ]);
        }else{
            return  redirect('/');
        }
    }

    public function save(){
        $data = request()->all();


        $company = companies_types::query()->updateOrCreate([
            'id'=>request()->has('id') ? request('id'):null,
        ],$data);

        // make report
        if(request()->has('id')){
            $content = 'قام '.auth()->user()->name.' بالتعديل علي الفرع الذي رقمه هو  '.request('id');
        }else{
            $content = 'قام '.auth()->user()->name.' بأنشاء فرع جديد الذي رقمه هو  '.$company->id;
        }
        reports::query()->create([
            'user_id'=>auth()->user()->id,
            'content'=>$content
        ]);

        return response()->json(['success'=>companies_types::query()->get()]);
    }
}
