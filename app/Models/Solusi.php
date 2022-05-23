<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solusi extends Model
{
    use HasFactory;

    protected $table = 'solusi';

    protected $fillable = [
        'id_mental',
        'solusi',
        'syarat',
        'updated_at',
        'created_at'
    ];

    protected $primaryKey = 'id_solusi';
}