<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\classes\Winnowing;
use App\classes\dice;
use App\skripsi;
use App\mahasiswa;

class CekController extends Controller
{
     public function index(){
        return view('cek');
    }

    public function proses(Request $request){
        $datas = skripsi::all();
        $request->session()->put('data',$request->input());
        foreach($datas as $key => $d){
            $text1 = $request->judul;
            $text2 = $d->judul;
            $abstrak1 = $request->abstrak;
            $abstrak2 = strip_tags(htmlspecialchars_decode($d->abstrak));
            $dice = new dice;
            $judul[]=  $dice->compare($text2,$text1);
            $abstrak[] = $dice->compare($abstrak2,$abstrak1);
            $value[] = $judul[$key] + $abstrak[$key];
         }
         $users= mahasiswa::all();
         $hasil = $value;
         $users_tertinggi = array_keys($hasil,max($hasil));
         $nilai_tertinggi = max($hasil);
        return view('user.tertinggi',compact('users','users_tertinggi','nilai_tertinggi','datas','request'));
        // return view('user.hasil',compact('hasil','datas','users'));
    }

    public function hasilseluruh(Request $request){
        $compare = $request->session()->get('data');
        $datas = skripsi::all();
        $request->session()->put('data',$compare);
        foreach($datas as $key => $d){
            $text1 = $compare['judul'];
            $text2 = $d->judul;
            $abstrak1 = $compare['abstrak'];
            $abstrak2 = strip_tags(htmlspecialchars_decode($d->abstrak));
            $dice = new dice;
            $judul[]=  $dice->compare($text2,$text1);
            $abstrak[] = $dice->compare($abstrak2,$abstrak1);
            $value[] = $judul[$key] + $abstrak[$key];
         }
         $users= mahasiswa::all();
         $hasil = $value;
         $users_tertinggi = array_keys($hasil,max($hasil));
         $nilai_tertinggi = max($hasil);
        // return view('user.tertinggi',compact('users','users_tertinggi','nilai_tertinggi','datas','request'));
        return view('user.hasil',compact('hasil','datas','users'));
    }

    public function detail(Request $request,skripsi $skripsi){
    
       $compare = $request->session()->get('data');
       $judul1 = $compare['judul'];
       $judul2 = $skripsi->judul;
       $abstrak1 = $compare['abstrak'];
       $abstrak2 = strip_tags(htmlspecialchars_decode($skripsi->abstrak));

       $dice = new dice;
       $judul = $dice->compare($judul2,$judul1);
       $abstrak = $dice->compare($abstrak2,$abstrak1);
       $akumulasi = $judul + $abstrak;
       $users = mahasiswa::all();
        
        return view('user.detail_cek',compact('users','skripsi','akumulasi','judul','abstrak'))->with('data',$request->session()->get('data'));
    }    

  
}
