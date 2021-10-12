<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\skripsi;
use App\prodi;
use File;
use RealRashid\SweetAlert\Facades\Alert;

class SkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    public function index()
    {
        // $skripsi = skripsi::all();
        $skripsi = DB::table('tbl_data')
        ->join('prodi','prodi.prodi_id','=','tbl_data.prodi_id')->orderby('id_data','desc')->get();
        return view('admin.skripsi.skripsi',compact('skripsi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prodis = prodi::all();
        return view('admin.skripsi.tambah',compact('prodis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'nim'=>'unique:tbl_data,nim',
        ]);
        require 'pdf.php';
        $pdf = upload($request);
        if(!$pdf){
            $skripsi = skripsi::create($request->all());
        }
        else{
            $skripsi = skripsi::create($request->all());
            skripsi::where('id_data',$skripsi->id_data)->update([
                'pdf'=>$pdf,
            ]);
        }

        Alert::success('Data Berhasil Ditambahkan');
        $skripsi = DB::table('tbl_data')
        ->join('prodi','prodi.prodi_id','=','tbl_data.prodi_id')->orderby('id_data','desc')->get();
        return view('admin.skripsi.skripsi',compact('skripsi'));
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Skripsi $skripsi)
    {
        
        return view('admin.skripsi.detail',compact('skripsi'));
    }

    public function download(Skripsi $skripsi){
        $header =[
            'content-type'=>'application/pdf',
        ];
        
          
          if($skripsi->pdf != null){
          $patch=public_path('storage/'.$skripsi->pdf);
          return response()->download($patch);
          }
          else{
            Alert::warning('jurnal tidak dapat di download');
            return view('admin.skripsi.detail',compact('skripsi'));
            // return view('admin.skripsi.show',$id)->with(['success' => 'Pesan Berhasil']);
          }
             
          
      }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(skripsi $skripsi)
    {
        
        $prodis = prodi::all();
        return view('admin.skripsi.edit',compact('skripsi','prodis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,skripsi $skripsi)
    {
        // return $request;
        require 'pdfedit.php';
        $pdf = upload($request);
        if(!$pdf){
            
        }
        elseif($pdf=="1"){
        $skripsi->update($request->all());
        skripsi::where('id_data',$skripsi->id_data)->update([
            'pdf'=>$request->pdflama,
        ]);
       
        }
        else{
            if($skripsi->pdf != null){
            File::delete('storage/'.$skripsi->pdf);
            }
            $skripsi->update($request->all());
            skripsi::where('id_data',$skripsi->id_data)->update([
                'pdf'=>$pdf,
            ]);
          
        }
        Alert::success('Edit Success');
        return view('admin.skripsi.detail',compact('skripsi'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(skripsi $skripsi)
    {
        if($skripsi->pdf != null){
        File::delete('storage/'.$skripsi->pdf);
        }
        Alert::success('Delete success');
        $skripsi->delete();
        $skripsi = DB::table('tbl_data')
        ->join('prodi','prodi.prodi_id','=','tbl_data.prodi_id')->orderby('id_data','desc')->get();
        return view('admin.skripsi.skripsi',compact('skripsi'));
    }
}
