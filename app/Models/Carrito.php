<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $table = 'carrito';

    protected $fillable = ['paciente_id'];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'carrito_producto')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

}
