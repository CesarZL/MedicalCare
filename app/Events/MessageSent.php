<?php

namespace App\Events;

use App\Models\MensajeChat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\BroadcastEvent;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $mensaje;

    public function __construct(MensajeChat $mensaje)
    {
        $this->mensaje = $mensaje;
    }

    public function broadcastOn()
    {
        return new Channel('cita.' . $this->mensaje->cita_id);
    }

    public function broadcastWith()
    {
        return [
            'mensaje' => [
                'usuario_id' => $this->mensaje->usuario_id,
                'mensaje' => $this->mensaje->mensaje,
                'cita_id' => $this->mensaje->cita_id,
            ],
        ];
    }
}
