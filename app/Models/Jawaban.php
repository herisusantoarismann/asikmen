<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;

    protected $table = 'jawaban';

    protected $fillable = [
        'id_user',
        'id_mental',
        'jawaban',
        'updated_at',
        'created_at'
    ];

    protected $primaryKey = 'id_jawaban';
}