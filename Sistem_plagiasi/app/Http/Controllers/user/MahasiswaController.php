<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\mahasiswa;
use App\user;
use File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //$idnya belum
    public function edit()
    {
        $users = mahasiswa::all();
        $mahasiswa = mahasiswa::all();
        return view('user.editprofil',compact('mahasiswa','users'));
    }

    public function update(Request $request,mahasiswa $mahasiswa)
    {
       
// return $request;
        if($request->email == $mahasiswa->email || $request->email == null){
            $request->validate([
            'no_telepon'=>'required|max:13|min:12',
            ]);
        }
        else{
            $request->validate([
                'email' =>'unique:users,email',
                ]);
            }

            require 'uploadedit.php';
        $gambar=upload($request);

        if(!$gambar){

        }
        elseif ($gambar == '1') {
            $mahasiswa->update($request->all());
            mahasiswa::where('user_id',$mahasiswa->user_id)->update([
                'foto'=>$mahasiswa->foto,
                'email'=>$request->email,
            ]);
            user::where('id',$mahasiswa->user_id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            ]);
            Alert::success('data berhasil di edit');
        }
        else{
            if($mahasiswa->foto != "profil/user.png"){
            File::delete('storage/'.$mahasiswa->foto);
            }
            $mahasiswa->update($request->all());
            mahasiswa::where('user_id',$mahasiswa->user_id)->update([
                'foto'=>$gambar,
                'email'=>$request->email,
            ]);
            user::where('id',$mahasiswa->user_id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            ]);
        }
        Alert::success('data berhasil di edit');
        $mahasiswa = mahasiswa::all();
        $users = mahasiswa::all();
        return view('user.editprofil',compact('mahasiswa','users'));
    }

    public function pass()
    {
        $users = mahasiswa::all();
        return view('user.changepw',compact('users'));
    }

    public function editpass(request $request)
    {
        $this->validator($request->all())->validate();

        auth()->user()->update(['password' => $request->input('password')]);

        return redirect()->back()->withStatus('Password changed successfully.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
