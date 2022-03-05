<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faktor extends Model
{
    use HasFactory;

    protected $table = 'faktor';

    protected $fillable = [
        'id_mental',
        'nama',
        'description',
        'updated_at',
        'created_at'
    ];

    protected $primaryKey = 'id_faktor';
}