<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    //modelo de la tabla categorias
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion'
    ];
}

