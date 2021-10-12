<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\admin;
use App\mahasiswa;
use App\skripsi;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $admins= admin::where('user_id',Auth::user()->id)->get();
        $a = count(admin::all());
        $mahasiswa = count(mahasiswa::all());
        $skripsi = count(skripsi::all());
        return view('admin.home',compact('admins','a','mahasiswa','skripsi'));
    }

}
