<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;
    
    protected $table = 'pertanyaan';

    protected $fillable = [
        'id_tes',
        'no_urut',
        'pertanyaan',
        'updated_at',
        'created_at'
    ];

    protected $primaryKey = 'id_pertanyaan';
}