<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;  
use App\User;

class user_management extends Controller
{
    //
    protected $startup_page = '/';
    protected $app_page = '/chat';

    public function show_startup_page() {
        return view('index');
    }

    public function start_up_redirect() {
        return $r->redirect($startup_page);
    }

    public function login(Request $request) {
        $request->session()->flash('form', 'login');

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended($this->app_page);
        }
        
        return back()->with('login_error','Invalid username and password');
    }

    public function sign_up(Request $request) {

        $request->session()->flash('form', 'sign_up');

        $data  = $request->validate([
            'name' => "required|regex:^[\\p{L} .'-]+$^",
            'email' => 'required|unique:App\User,email',
            'username' => 'unique:App\User,username|required|max:155',
            'password' => 'required'
        ]);
        $data['password'] = Hash::make($data['password']);
        
        try {

            $user = User::create($data);
            $user->username = $data['username'];
            $user->save();

            $this->login($request);

        } catch (\Exception $e) {
            
           // abort($e->getCode(), $e->getMessage(),['Content'=> 'text/html']);
           abort( response($e->getMessage(), 404));
        }
    }

    public function logout() {
        Auth::logout();
        return redirect($this->startup_page);
    }

}
