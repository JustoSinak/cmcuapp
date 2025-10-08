<?php

namespace App\Events;

use App\Models\Patient;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PatientUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $patient;
    public $updateType;
    public $updatedBy;

    /**
     * Create a new event instance.
     */
    public function __construct(Patient $patient, string $updateType = 'updated', $updatedBy = null)
    {
        $this->patient = $patient;
        $this->updateType = $updateType;
        $this->updatedBy = $updatedBy ?: auth()->user();
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('hospital.updates'),
            new PrivateChannel('patient.' . $this->patient->id),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'patient' => [
                'id' => $this->patient->id,
                'nom' => $this->patient->nom,
                'prenom' => $this->patient->prenom,
                'telephone' => $this->patient->telephone,
                'updated_at' => $this->patient->updated_at->toISOString(),
            ],
            'update_type' => $this->updateType,
            'updated_by' => [
                'id' => $this->updatedBy?->id,
                'name' => $this->updatedBy?->name,
            ],
            'timestamp' => now()->toISOString(),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'patient.updated';
    }
}
