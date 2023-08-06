<?php

namespace App\Http\Controllers;

use App\Models\companies_types;
use App\Models\countries;
use App\Models\destinations;
use App\Models\exporters;
use App\Models\info_data;
use App\Models\reports;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    //
    public function delete(){
        if(request('table') == 'users'){
            reports::query()->create([
               'user_id'=>auth()->user()->id,
               'content'=>'قام ' .auth()->user()->name.' بحذف المستخم الذي اسمه هو '.User::query()->find(request('id'))->name
            ]);
            User::query()->find(request('id'))->delete();
        }else if(request('table') == 'companies_types'){
            reports::query()->create([
                'user_id'=>auth()->user()->id,
                'content'=>'قام ' .auth()->user()->name.' بحذف الفرع الذي اسمه هو '.companies_types::query()->find(request('id'))->name
            ]);
            companies_types::query()->find(request('id'))->delete();
        }else if(request('table') == 'info_datas'){
            reports::query()->create([
                'user_id'=>auth()->user()->id,
                'content'=>'قام ' .auth()->user()->name.' بحذف البيان الذي رقمه هو '.request('id')
            ]);
            info_data::query()->find(request('id'))->delete();
        }else if(request('table') == 'countries'){
            reports::query()->create([
                'user_id'=>auth()->user()->id,
                'content'=>'قام ' .auth()->user()->name.' بحذف المنشأ الذي رقمه هو '.request('id')
            ]);
            countries::query()->find(request('id'))->delete();
        }else if(request('table') == 'exporters'){
            reports::query()->create([
                'user_id'=>auth()->user()->id,
                'content'=>'قام ' .auth()->user()->name.' بحذف المصدر الذي رقمه هو '.request('id')
            ]);
            exporters::query()->find(request('id'))->delete();
        }else if(request('table') == 'destinations'){
            reports::query()->create([
                'user_id'=>auth()->user()->id,
                'content'=>'قام ' .auth()->user()->name.' بحذف الوجهة التي رقمها هو '.request('id')
            ]);
            destinations::query()->find(request('id'))->delete();
        }
       // DB::table(request('table'))->where('id',request('id'))->delete();
        echo 1;
    }

    public function restore(){
        DB::table(request('table'))->where('id','=',request('id'))->update([
           'deleted_at'=>null,
        ]);
    }
}
