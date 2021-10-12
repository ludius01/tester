<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'nim';

    public $fillable = ['prodi_id','name','password','email','jenis_kelamin','tanggal_lahir','nim','no_telepon','alamat','foto','user_id'];

    public $table = 'mahasiswa';
}
