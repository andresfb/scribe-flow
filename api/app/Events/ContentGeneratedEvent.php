<?php

namespace App\Events;

use App\Models\GeneratorRequest;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContentGeneratedEvent implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(private readonly GeneratorRequest $request) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("generator.{$this->request->id}")
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'type' => $this->request->type->value,
            'status' => $this->request->status->value,
            'service' => $this->request->service ?? 'None',
            'model' => $this->request->model ?? 'None',
            'message' => $this->request->message ?? '',
        ];
    }
}
