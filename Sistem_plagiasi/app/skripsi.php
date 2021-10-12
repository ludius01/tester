<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class skripsi extends Model
{
    protected $table = 'tbl_data';
    public $timestamps = false;
    public $primaryKey ='id_data';
    protected $fillable = ['judul','abstrak','nama_penulis','nim','dosen1','dosen2','keterangan','prodi_id','pdf'];
}
