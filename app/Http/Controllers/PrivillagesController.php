<?php

namespace App\Http\Controllers;

use App\Http\Requests\role_permission;
use App\Models\Permissions;
use App\Models\Role_Permissions;
use App\Models\Roles;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Traits\output_messages;
class PrivillagesController extends Controller
{
    //

    use output_messages;

    public function index(){
        $roles = Roles::with('permissions')->where('name','!=','مدير')->latest()->get();
        $all_premissions = Permissions::query()->get()->groupBy('type');

        return Inertia::render('privillages',[
            'roles'=>$roles,
            'permissions'=>$all_premissions,
        ]);
    }

    public function saverole(role_permission $role_permission){
        $data = $role_permission->validated();
        // create new role
        $role = Roles::updateOrCreate(
            [
                'id'=>request()->has('id') ? request('id'):null
            ]
            ,
            [
                'name'=>$data['name']
            ]
        );
        if(request()->has('id')){
            // delete all privillages
            $privillages = Role_Permissions::query()->whereIn('permission_id',$data['privillages'])->delete();

        }
        foreach ($data['privillages'] as $p) {
            Role_Permissions::create([
                'role_id' => $role->id,
                'permission_id' => $p
            ]);
        }


        return $this->success_output(Roles::with('permissions')->where('name','!=','مدير')->latest()->get());

    }
}
