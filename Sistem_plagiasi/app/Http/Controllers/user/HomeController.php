<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\skripsi;
use App\user;
use App\mahasiswa;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $users = user::all();
        return view('admin.home',compact('users'));
    }

    public function user(){
        $users = mahasiswa::all();
        return view('user.home',compact('users'));
    }

    public function cek(){
        $users = mahasiswa::all();
        return view('user.cek_plagiasi',compact('users'));
    }

    public function list(){
        $users = mahasiswa::all();
        $skripsi = skripsi::all();
        return view('user.list',compact('skripsi','users'));
    }

    public function detail(skripsi $id){
        $users = mahasiswa::all();
        return view('user.detail_skripsi',compact('id','users'));
    }
}
