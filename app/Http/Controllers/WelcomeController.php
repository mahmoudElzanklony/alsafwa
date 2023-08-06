<?php

namespace App\Http\Controllers;

use App\Filters\UsersFilterEmail;
use App\Filters\UsersFilterName;
use App\Models\Clients;
use App\Models\companies_types;
use App\Models\Documents;
use App\Models\Engineers;
use App\Models\info_data;
use App\Models\reports;
use App\Models\Services;
use App\Models\Services_Clients_Costs;
use App\Models\Services_Requests;
use App\Models\User;
use App\Models\users_companies;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;
use Inertia\Inertia;
use function PHPUnit\Framework\throwException;







class WelcomeController extends Controller
{
    //



    public function index(){
/*
       return User::query()->select(['id','created_at'])
        ->orderByRaw('created_at is null')
        ->orderBy('created_at')
        ->get();*/


        if(auth()->user()->type == 'admin'){
            $data = info_data::query()->count();
            $success_projects = info_data::query()->where('status','1')->count();
        }else {
            $data = info_data::query()->where('user_id','=',auth()->user()->id)->count();
            $success_projects = info_data::query()->where('user_id','=',auth()->id())
                ->where('status','1')->count();
        }
        return Inertia::render('welcome',[
            'employees'=>User::count(),
            'companies'=>companies_types::count(),
            'info_data'=>$data,
            'reports'=>reports::query()->count(),
            'success_projects'=>$success_projects,
        ]);
    }

    public function statics_data(){

        $total_services_prices = Services_Requests::query()
            ->whereBetween('services__requests.created_at',[request('start'),request('end') ])
            ->selectRaw('sum(price) as total')->get()[0]['total'];

        $data = DB::table('services__requests')
            ->join('services__clients__costs','services__clients__costs.service_request_id','services__requests.id')
            ->select(DB::raw('count(services__requests.id) as total_requests ,
                    sum(services__clients__costs.total) as total_taken ,
                    sum(services__clients__costs.arrived) as total_costs'))
            ->when(request('start') && request('end'),function ($q){
                $q->whereBetween('services__requests.created_at',[request('start'),request('end') ]);
            })
            ->get();
        return response()->json([
            'total_services_prices'=>$total_services_prices,
            'data'=>$data[0],
        ]);
    }
    public function statics(){
        $user = User::query()->where('id',auth()->id())->with('role')->first();
        if($user->role->name == "مدير") {
            $total_services_prices = Services_Requests::query()->selectRaw('sum(price) as total')->get()[0]['total'];
            // return $total_services_prices;

            $data = DB::table('services__requests')
                ->join('services__clients__costs', 'services__clients__costs.service_request_id', 'services__requests.id')
                ->select(DB::raw('count(services__requests.id) as total_requests ,
                    sum(services__clients__costs.total) as total_taken ,
                    sum(services__clients__costs.arrived) as total_costs'))
                ->when(request('start') && request('end'), function ($q) {
                    $q->whereBetween('services__requests.created_at', [request('start'), request('end')]);
                })
                ->get();
            return Inertia::render('filter_count_data', [
                'total_services_prices' => $total_services_prices,
                'data' => $data[0]
            ]);
        }else{
            return redirect('/');
        }
    }
}
