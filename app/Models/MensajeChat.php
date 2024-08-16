<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajeChat extends Model
{
    use HasFactory;

    protected $table = 'mensajes';

    protected $fillable = ['cita_id', 'usuario_id', 'mensaje'];


    // Relación con Cita
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
