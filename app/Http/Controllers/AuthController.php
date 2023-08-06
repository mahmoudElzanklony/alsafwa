<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use App\Http\Traits\output_messages;
class AuthController extends Controller
{
    //
    use output_messages;
    public function login(){
        if(auth()->check()){
            return  redirect('/');
        }else {
            return Inertia::render('login');
        }
    }

    public function login_auth(Users $users){
       if(auth()->attempt($users->validated())){
            // he is login
            $user = User::query()->with('companies')->get();

            session()->put('user',$user);

            return $this->success_output($user);
       }else{
           // he is not logined
           return $this->error_output(trans('general_messages.failed_auth'));
       }
    }

    public function logout(){
        auth()->logout();
        return redirect('/login');
    }
}
