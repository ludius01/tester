<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\admin;
use App\mahasiswa;
use App\skripsi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Gate;
use File;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{

    public function index()
    {
        $admins = admin::all();
        return view('admin.user.admin.index',compact('admins'));
    }

    public function create()
    {
        return view('admin.user.admin.create');
    }

    public function store(Request $request)
    {
        require 'upload.php';
        $gambar = upload($request);
        if(!$gambar || $gambar==1){

        }
        else{
            $user = User::create($request->all());
            $id = $user->id;
            $admin = admin::create($request->all());
            admin::where('admin_id',$admin->admin_id)->update([
                'user_id'=>$id,
                'foto'=> $gambar,
            ]);
            Alert::success('data berhasil di tambah');
            return redirect()->route('admin.admin.index');
        }
    }
    public function show($id)
    {
        
    }
    public function edit($id)
    {
        $admin = admin::where('user_id',$id)->first();
        return view('admin.user.admin.edit',compact('admin'));
    }
    public function update(Request $request,admin $admin)
    {
        // return $request;
        require 'uploadedit.php';
        $gambar = upload($request);
        if(!$gambar){
            
        }
        elseif($gambar=='1'){
            $admin->update($request->all());
            admin::where('user_id',$admin->user_id)->update([
                'foto'=>$admin->foto,
                'tanggal_lahir'=>$request->tanggal_lahir,
            ]);
            user::where('id',$admin->user_id)->update([
                'name'=>$request->name,
                // 'email'=>$request->email,
                ]);
        }
            else{
                File::delete('storage/'.$admin->foto);
                $admin->update($request->all());
                admin::where('user_id',$admin->user_id)->update([
                    'foto'=>$gambar,
                    'tanggal_lahir'=>$request->tanggal_lahir,
                ]);
                user::where('id',$admin->user_id)->update([
                'name'=>$request->name,
                // 'email'=>$request->email,
                ]);
            }
            
            Alert::success('data berhasil di edit');
            $admins= admin::where('user_id',Auth::user()->id)->get();
            $a = count(admin::all());
            $mahasiswa = count(mahasiswa::all());
            $skripsi = count(skripsi::all());
            return view('admin.home',compact('admins','a','mahasiswa','skripsi'));
    }

    public function destroy($id)
    {
        //
    }

    public function pass($id){
        // return $id;
        return view('admin.changepw',compact('id'));
    }
    public function setpass(request $request){
        // return $request;
        mahasiswa::where('user_id',$request->id)->update([
            'password'=>$request->password,
        ]);

        $this->validator($request->all())->validate();
        User::where('id',$request->id)->update(['password'=>hash::make($request['password'])]);
        return redirect()->back()->withStatus('Password changed successfully.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
