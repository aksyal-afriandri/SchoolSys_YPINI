<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelajaranModel extends Model
{
    //
    use HasFactory;
    protected $table = 'data_pelajaran';
    protected $fillable = ['nama_pelajaran'];
}
