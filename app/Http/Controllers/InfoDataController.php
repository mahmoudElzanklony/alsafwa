<?php

namespace App\Http\Controllers;

use App\Models\companies_types;
use App\Models\countries;
use App\Models\destinations;
use App\Models\exporters;
use App\Models\info_data;
use App\Models\reports;
use App\Models\users_companies;
use App\Models\users_destinations_permissions;
use App\Models\users_exporters_permissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class InfoDataController extends Controller
{
    //
    public function index(){




        if(auth()->user()->type == 'admin'){
            $companies = companies_types::query()->get();
            $data = info_data::query()
                ->with('company',function ($q){
                    $q->where('deleted_at','=',null);
                })
                ->with('user')
                ->with('destination',function ($q){
                    $q->where('deleted_at','=',null);
                })
                ->with('exporter',function ($q){
                    $q->where('deleted_at','=',null);
                })
                ->with('country',function ($q){
                    $q->where('deleted_at','=',null);
                })
                ->when(request()->has('sort') &&
                    request('sort') == 'one',function($q){
                    $q->whereRaw('(company_id is null || item is null || country_id is null || exporter_id is null || bill_number is null || bill_value is null || number_data is null || weight is null || ACID is null || permission is null || destination_id is null)
                    OR (
                        (company_id is not null && item is not null && country_id is not null && exporter_id is not null && bill_number is not null && bill_value is not null && number_data is not null && weight is not null && ACID is not null && permission is not null && destination_id is not null)
                        and
                        (
                             (number_container is  null && line is  null && policy is  null && vehicle is  null
                             && arrived is  null)

                        )
                    )')
                    ;
                })
                ->when(request()->has('sort') &&
                    request('sort') == 'two',function($q){
                    $q->whereRaw('(company_id is not null && item is not null && country_id is not null && exporter_id is not null && bill_number is not null && bill_value is not null && number_data is not null && weight is not null && ACID is not null && permission is not null && destination_id is not null)
                    and
                    (
                        (
                            (number_container is null and (line is not null || policy is not null || vehicle is not null || arrived is not null))
                            or
                            (line is null and (number_container is not null || policy is not null || vehicle is not null || arrived is not null))
                            or
                            (policy is null and (number_container is not null || line is not null || vehicle is not null || arrived is not null))
                            or
                            (vehicle is null and (number_container is not null || line is not null || policy is not null || arrived is not null))
                            or
                            (arrived is null and (number_container is not null || line is not null || policy is not null || vehicle is not null))
                        )
                        or
                        (
                            (number_container is not null && line is not null && policy is not null && vehicle is not null && arrived is not null)
                            and
                            (allowed is null && instructions_status is null && lifting_status is null && forty_six_number is null && request_number is null && statement_status is null && notes is null && exchange_date is null && matching_status is null)
                        )
                    )
                    ');
                })
                ->when(request()->has('sort') &&
                    request('sort') == 'three',function($q){
                    $q->whereRaw('(
                         company_id is not null && item is not null && country_id is not null &&
                         exporter_id is not null && bill_number is not null && bill_value is not null
                          && number_data is not null && weight is not null && ACID is not null &&
                          permission is not null && destination_id is not null &&
                          number_container is not null && line is not null && policy is not null && vehicle is not null && arrived is not null
                      ) AND (allowed is not null || instructions_status is not null || lifting_status is not null || forty_six_number is not null || request_number is not null || statement_status is not null || notes is not null || exchange_date is not null || matching_status is not null)');
                })
                ->when(request()->has('sort') &&
                    (
                        request('sort') == 'id' || request('sort') == 'updated_at' ||request('sort') == 'arrived'
                    ),function($q){
                    $q
                        ->whereRaw('info_datas.'.(request('sort') ?? 'id').' IS NOT NULL')
                        ->orderBy('info_datas.'.(request('sort') ?? 'id'),'desc');
                })
                ->where('status','=',request('status'))

                ->get();
            $user_destinations = null;
        }else {
            $companies = users_companies::query()->with('company')
                ->where('user_id', '=', auth()->user()->id)->get();

            $companies_arr =  $companies->map(function ($e){
                return $e['company_id'];
            });
            $user_destinations = users_destinations_permissions::query()->with('destination')
                ->where('user_id','=',auth()->user()->id)->get();


            $destinations_ids =  $user_destinations->map(function ($e){
                return $e['destination_id'];
            });

            $user_exporters = users_exporters_permissions::query()->with('exporter')
                ->where('user_id','=',auth()->user()->id)->get();


            $exporters_ids =  $user_exporters->map(function ($e){
                return $e['exporter_id'];
            });

            $data = info_data::query()
                ->with('company',function ($q){
                    $q->where('deleted_at','=',null);
                })
                ->with('user')
                ->with('destination',function ($q){
                    $q->where('deleted_at','=',null);
                })
                ->with('exporter',function ($q){
                    $q->where('deleted_at','=',null);
                })
                ->with('country',function ($q){
                    $q->where('deleted_at','=',null);
                })
                ->whereIn('company_id',$companies_arr)
                ->whereIn('destination_id',$destinations_ids)
                ->when(sizeof($exporters_ids) > 0 , function ($e) use ($exporters_ids){
                    $e->whereIn('exporter_id',$exporters_ids);
                })
                ->where('status','=',request('status'))
                ->when(request()->has('sort') &&
                    request('sort') == 'one',function($q){
                    $q->whereRaw('(company_id is null || item is null || country_id is null || exporter_id is null || bill_number is null || bill_value is null || number_data is null || weight is null || ACID is null || permission is null || destination_id is null)')
                    ;
                })
                ->when(request()->has('sort') &&
                    request('sort') == 'two',function($q){
                    $q->whereRaw('(company_id is not null && item is not null && country_id is not null && exporter_id is not null && bill_number is not null && bill_value is not null && number_data is not null && weight is not null && ACID is not null && permission is not null && destination_id is not null) and
                    (number_container is null || line is null || policy is null || vehicle is null || arrived is null || allowed is null || instructions_status is null || lifting_status is null)');
                })
                ->when(request()->has('sort') &&
                    request('sort') == 'three',function($q){
                    $q->whereRaw('(
                         company_id is not null && item is not null && country_id is not null &&
                         exporter_id is not null && bill_number is not null && bill_value is not null
                          && number_data is not null && weight is not null && ACID is not null &&
                          permission is not null && destination_id is not null
                      ) and
                    (number_container is not null && line is not null && policy is not null && vehicle is not null && arrived is not null && allowed is not null && instructions_status is not null && lifting_status is not null )');
                })
                ->when(request()->has('sort') &&
                    (
                        request('sort') == 'id' || request('sort') == 'updated_at' ||request('sort') == 'arrived'
                    ),function($q){
                    $q
                        ->where('info_datas.'.(request('sort') ?? 'id'),'!=','null')
                        ->orderBy('info_datas.'.(request('sort') ?? 'id'),'desc');
                })
                ->get();


        }
        return Inertia::render('info_data',[
           'companies'=>$companies,
           'data'=>$data,
           'user_destinations'=>$user_destinations,
           'destinations'=>destinations::query()->get(),
           'countries'=>countries::query()->get(),
           'exporters'=>exporters::query()->get(),
        ]);
    }

    public function save(){
        $data = request()->all();
        $data['user_id'] = auth()->user()->id;
        // exchange_date
        // check if status ia null
        if(request('status') == null){
            $data['status'] = 0;
        }
        if(str_contains(request('exchange_date'), '/')){
             $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }


        // foreign keys
        $foreign = ['company_id','country_id','exporter_id','destination_id'];

        foreach ($foreign as $f){
            if(request($f) == ''){
                $data[$f] = null;
            }
        }
        if(!(request()->has('id'))){
            unset($data['status_url']);


            $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
            $data['updated_at'] = null;
            $info_added = DB::table('info_datas')->insertGetId($data);
            $info_saved  = info_data::query()->with(['user','destination','country','exporter'])
                ->with('company',function ($q){
                    $q->where('deleted_at','=',null);
                })
                ->where('id','=',$info_added)->first();
        }else {
            $info_added = info_data::query()->updateOrCreate([
                'id' => request()->has('id') ? request('id') : null,
            ], $data);

            $info_added->touch();

            $info_saved  = info_data::query()->with(['user','destination','country','exporter'])
                ->with('company',function ($q){
                    $q->where('deleted_at','=',null);
                })
                ->where('id','=',$info_added->id)->first();
        }
        // make report
        if(request()->has('id')){
            $content = 'قام '.auth()->user()->name.' بالتعديل علي البيان الذي رقمه هو  '.request('id');
        }else{
            $content = 'قام '.auth()->user()->name.' بأنشاء بيان جديد الذي رقمه هو  '.$info_saved->id;
        }
        reports::query()->create([
            'user_id'=>auth()->user()->id,
            'content'=>$content
        ]);
/*
        if(auth()->user()->type == 'admin'){
            $data = info_data::query()->with(['company','user','destination','country','exporter'])
                ->whereHas('company',function ($q){
                    $q->where('deleted_at','=',null);
                })
                ->where('status','=',request('status_url'))->get();
        }else {
            $companies = users_companies::query()->with('company')
                ->where('user_id', '=', auth()->user()->id)->get();
            return $companies;

            $companies_arr =  $companies->map(function ($e){
                return $e['company_id'];
            });

            $user_destinations = users_destinations_permissions::query()->with('destination')
                ->where('user_id','=',auth()->user()->id)->get();

            $destinations_ids =  $user_destinations->map(function ($e){
                return $e['destination_id'];
            });

            $data = info_data::query()->with(['company','user','destination','country','exporter'])
                ->whereHas('user',function ($q){
                    $q->where('deleted_at','=',null);
                })
                ->whereHas('destination',function ($q){
                    $q->where('deleted_at','=',null);
                })
                ->whereHas('exporter',function ($q){
                    $q->where('deleted_at','=',null);
                })
                ->whereHas('country',function ($q){
                    $q->where('deleted_at','=',null);
                })
                ->whereIn('company_id',$companies_arr)
                ->whereIn('destination_id',$destinations_ids)
                ->where('status','=',request('status_url'))->get();
        }
*/


        return response()->json(['success'=>$info_saved,
            'id_status'=>request()->has('id') ? request('id'):null,
            ]);
    }
}
