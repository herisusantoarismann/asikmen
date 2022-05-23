<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'id_mental',
        'id_faktor',
        'nama',
        'nilai',
        'updated_at',
        'created_at'
    ];

    protected $primaryKey = 'id_kategori';
}