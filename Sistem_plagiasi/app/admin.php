<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    protected $primaryKey = 'admin_id';
    public $table = 'admin';
    public $timestamps =false;
    protected $fillable =['name','email','password','alamat','tanggal_lahir','jenis_kelamin','no_telepon'];
}
