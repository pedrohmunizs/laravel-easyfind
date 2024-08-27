<?php

namespace App\Events;

use App\Models\Produto;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateTotalProdutoSold
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $produto;
    public $qtd;

    /**
     * Create a new event instance.
     */
    public function __construct(Produto $produto, $qtd)
    {
        $this->produto = $produto;   
        $this->qtd = $qtd;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
