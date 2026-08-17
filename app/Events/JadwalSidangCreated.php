<?php

namespace App\Events;

use App\Models\JadwalSidang;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JadwalSidangCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $jadwal;

    public function __construct(JadwalSidang $jadwal)
    {
        $this->jadwal = $jadwal;
    }

    public function broadcastOn(): array
    {
        // Channel umum yang didengarkan oleh para User
        return [
            new Channel('jadwal-sidang-channel'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'jadwal.created';
    }
}
