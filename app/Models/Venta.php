<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'paciente_id', 'fecha_de_venta', 'subtotal', 'IVA', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'venta_producto')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

}
