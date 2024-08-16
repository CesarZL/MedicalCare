<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = ['medico_id', 'paciente_id', 'fecha_hora', 'status'];

    public function aceptar()
    {
        $this->update(['status' => 'aceptada']);
    }

    public function cancelar()
    {
        $this->update(['status' => 'cancelada']);
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function mensajes()
    {
        return $this->hasMany(MensajeChat::class);
    }

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];



}
