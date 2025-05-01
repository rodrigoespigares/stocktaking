<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;
    
    protected $table = 'productos';

    protected $fillable = [
        'referencia',
        'nombre',
        'precio',
        'precio_publico',
        'cantidad',
    ];
}
