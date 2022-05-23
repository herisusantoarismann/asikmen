<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aturan extends Model
{
    use HasFactory;

    protected $table = 'aturan';

    protected $fillable = [
        'id_mental',
        'aturan',
        'hasil',
        'updated_at',
        'created_at'
    ];

    protected $primaryKey = 'id_aturan';
}