<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mental extends Model
{
    use HasFactory;

    protected $table = 'mental';

    protected $fillable = [
        'nama',
        'description',
        'updated_at',
        'created_at'
    ];

    protected $primaryKey = 'id_mental';
}