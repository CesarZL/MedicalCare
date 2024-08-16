<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'imagen',
        'cedula',
        'especialidad',
        'direccion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    
}
