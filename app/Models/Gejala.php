<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;

    protected $table = 'gejala';

    protected $fillable = [
        'id_faktor',
        'nama',
        'updated_at',
        'created_at'
    ];

    protected $primaryKey = 'id_gejala';
}