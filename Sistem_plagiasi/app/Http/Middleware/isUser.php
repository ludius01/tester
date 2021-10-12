<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class isUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }
        if(auth()->user()->level == 'user'){
            return $next($request);
        }
            if(auth()->user()->level == 'admin'){
                return redirect()->route('admin.home');
                }
        return redirect('login')->with('error',"you dont have permisson");
    }
}
