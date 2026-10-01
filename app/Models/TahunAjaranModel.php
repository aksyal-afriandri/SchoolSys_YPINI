<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaranModel extends Model
{
    //
    use HasFactory;
    protected $table = 'tahun_ajaran';
    protected $fillable = ['tahun_ajaran'];
}
