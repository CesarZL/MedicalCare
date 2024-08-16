<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sexo',
        'tipo_sangre',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

}
