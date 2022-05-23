<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    use HasFactory;

    protected $table = 'hasil';

    protected $fillable = [
        'id_user',
        'hasil',
        'updated_at',
        'created_at'
    ];

    protected $primaryKey = 'id_hasil';
}