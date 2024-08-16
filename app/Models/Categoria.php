<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    //relacion uno a muchos
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    //relacion uno a muchos
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
    
}
