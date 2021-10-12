<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        
        $input = $request->all();
        // return $input['email'];
        $this->validate($request,[
            'email'=>'required',
            'password' => 'required',
        ]);

    $type = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email':'username';  
    
    // return $type;

        if(auth()->attempt(array($type=>$input['email'],'password'=>$input['password']))){
            if(auth()->user()->level =='admin'){
                return redirect()->route('admin.home');
            }
            elseif(auth()->user()->level =='user'){
                return redirect()->route('user.dashboard');
            }
            else{
                return redirect()->route('login');
            }
        }

        else{
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.failed')],
            ]);
            return redirect()->route('login');
        }
    }
    public function username()
    {
        return 'email';
    }

}
