<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users;
use App\Models\companies_types;
use App\Models\destinations;
use App\Models\exporters;
use App\Models\reports;
use App\Models\Role_Permissions;
use App\Models\User;
use App\Models\users_companies;
use App\Models\users_destinations_permissions;
use App\Models\users_exporters_permissions;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Traits\output_messages;
class UsersController extends Controller
{
    //

    use output_messages;

    public function index(){
        if(auth()->user()->type == 'admin') {
            $users = User::query()
                ->with('companies', function ($e) {
                    $e->has('company')->with('company')->whereHas('company', function ($q) {
                        $q->where('deleted_at', '=', null);
                    });
                })->with('destinations', function ($e) {
                    $e->has('destination')->with('destination',function ($e){
                        $e->where('deleted_at','=',null);
                    });
                })->with('exporters', function ($e) {
                    $e->has('exporter')->with('exporter',function ($e){
                        $e->where('deleted_at','=',null);
                    });
                })
                ->get();

            return Inertia::render('users_data', [
                'users' => $users,
                'destinations'=>destinations::query()->get(),
                'companies' => companies_types::query()->get(),
                'exporters' => exporters::query()->get(),
            ]);
        }else{
            return redirect('/');
        }
    }

    public function save(Users $users){
        $data = $users->validated();
        if(!(request()->filled('control'))){
            $data['control'] = 0;
        }

        if($data['password'] == null){
            unset($data['password']);
        }else{
            $data['password']= bcrypt(request('password'));
        }
        if(request()->has('id')){
            $user = User::query()->find(request('id'));
            $data['type'] = $user->type;
        }else {
            $data['type'] = 'employee';
        }

        $user = User::query()->updateOrCreate([
            'id'=>request()->has('id') ? request('id'):null,
        ],$data);

        // make report
        if(request()->has('id')){
            $content = 'قام '.auth()->user()->name.' بالتعديل علي المستخدم الذي رقمه هو  '.request('id');
        }else{
            $content = 'قام '.auth()->user()->name.' بأنشاء مستخدم جديد الذي رقمه هو  '.$user->id;
        }
        reports::query()->create([
            'user_id'=>auth()->user()->id,
            'content'=>$content
        ]);

        if(request()->has('id')){
            // delete all privillages
            $user_companies = users_companies::query()
                ->where('user_id',$user->id)->forceDelete();
            $user_destinations = users_destinations_permissions::query()
                ->where('user_id',$user->id)->forceDelete();
            $user_exporters = users_exporters_permissions::query()
                ->where('user_id',$user->id)->forceDelete();

        }
        if(request()->has('compaines')) {
            foreach (request('compaines') as $c) {
                users_companies::create([
                    'user_id' => $user->id,
                    'company_id' => $c
                ]);
            }
        }
        if(request()->has('destinations')) {
            foreach (request('destinations') as $c) {
                users_destinations_permissions::create([
                    'user_id' => $user->id,
                    'destination_id' => $c
                ]);
            }
        }
        if(request()->has('exporters')) {
            foreach (request('exporters') as $c) {
                users_exporters_permissions::create([
                    'user_id' => $user->id,
                    'exporter_id' => $c
                ]);
            }
        }

        return response()->json(['success'=>User::query()
            ->with('companies', function ($e) {
                $e->has('company')->with('company')->whereHas('company', function ($q) {
                    $q->where('deleted_at', '=', null);
                });
            })->with('destinations', function ($e) {
                $e->has('destination')->with('destination',function ($e){
                    $e->where('deleted_at','=',null);
                });
            })->with('exporters', function ($e) {
                $e->has('exporter')->with('exporter',function ($e){
                    $e->where('deleted_at','=',null);
                });
            })
            ->get()]);
    }
}
