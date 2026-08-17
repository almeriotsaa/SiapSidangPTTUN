<?php

namespace App\Events;

use App\Models\Kehadiran;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KehadiranUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $kehadiran;

    public function __construct(Kehadiran $kehadiran)
    {
        $this->kehadiran = $kehadiran;
    }

    public function broadcastOn()
    {
        return new Channel('kehadiran-channel');
    }

    public function broadcastAs()
    {
        return 'kehadiran.updated';
    }
}
