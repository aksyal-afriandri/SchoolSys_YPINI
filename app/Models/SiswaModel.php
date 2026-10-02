<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaModel extends Model
{
use HasFactory;
    //
    protected $table = 'data_siswa';
    protected $fillable = ['nama', 'nisn', 'photo'];
}
