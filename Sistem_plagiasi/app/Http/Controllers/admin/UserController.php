<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\mahasiswa;
use App\user;
use App\prodi;
use Gate;
use File;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(){
        $mahasiswa = mahasiswa::where('prodi_id','1')->get();
        $prodi = prodi::all();
        $id = '1';
        return view('admin.user.mahasiswa.Ti',compact('mahasiswa','prodi','id'));
    }

    public function list($id){
        // return 'berhasil';
        $mahasiswa = mahasiswa::where('prodi_id',$id)->get();
        $prodi = prodi::all();
        return view('admin.user.mahasiswa.Ti',compact('mahasiswa','prodi','id'));
    }

    public function create()
    {
        $prodis = prodi::all();
        return view('admin.user.mahasiswa.tambah',compact('prodis'));
    }

    public function store(Request $request)
    {
        // return $request;
        require 'upload.php';
        if($request->no_telepon != null){
        $request->validate([
            'no_telepon'=>'max:13|min:12',
            'nim'=>'unique:mahasiswa,nim',
        ]);
        }
        elseif($request->email != null){
            $request->validate([
            'nim'=>'unique:mahasiswa,nim',
            'email' =>'unique:users,email',
            ]);
        }
        else{
            $request->validate([
                'nim'=>'unique:mahasiswa,nim',
                // 'email' =>'unique:users,email',
            ]); 
        }
        $gambar = upload($request);
        if(!$gambar || $gambar==1){

        }
        else{
            $user= user::create($request->all());
            $id = $user->id;
            $mahasiswa = mahasiswa::create($request->all());
            mahasiswa::where('nim',$request->nim)->update([
                'user_id'=>$id,
                'foto'=>$gambar,
            ]);
            user::where('id',$id)->update([
                'username'=>$request->nim,
            ]);
                Alert::success('data berhasil di tambah');
                return redirect()->route('admin.mahasiswa.index');
           
        }

    }

    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $mahasiswa = mahasiswa::where('nim',$id)->get();
        return view('admin.user.mahasiswa.edit',compact('mahasiswa'));
    }

    public function update(Request $request,mahasiswa $mahasiswa)
    {
        if($mahasiswa->email == $request->email || $request->no_telepon != null){
            $request->validate([
            'no_telepon'=>'max:13|min:12',
            ]);
        }
        else{
            $request->validate([
                'email' =>'unique:users,email',
                ]);
            }
       
        require 'uploadedit.php';
        $gambar = upload($request);
        if(!$gambar){
            
        }
        elseif($gambar=='1'){
            $mahasiswa->update($request->all());
            mahasiswa::where('user_id',$mahasiswa->user_id)->update([
                'foto'=>$mahasiswa->foto,
            ]);
            user::where('id',$mahasiswa->user_id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            ]);
        }
        else{
            if($mahasiswa->foto != "profil/user.png"){
                File::delete('storage/'.$mahasiswa->foto);
                }
            $mahasiswa->update($request->all());
            mahasiswa::where('user_id',$mahasiswa->user_id)->update([
                'foto'=>$gambar,
            ]);
            user::where('id',$mahasiswa->user_id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            ]);
        }
    $id = $mahasiswa->prodi_id;
    $mahasiswa = mahasiswa::where('prodi_id',$id)->get();
    $prodi = prodi::all();
    Alert::success('data berhasil di edit');
    return view('admin.user.mahasiswa.ti',compact('mahasiswa','prodi','id'));
    }

    public function destroy(mahasiswa $mahasiswa)
    {
        if($mahasiswa->foto != "profil/user.png"){
            File::delete('storage/'.$mahasiswa->foto);
            }
        Alert::success('user berhasil di hapus');
        user::where('id',$mahasiswa->user_id)->delete();
        $mahasiswa->delete();
        
        return redirect()->route('admin.mahasiswa.index');
    }
}
