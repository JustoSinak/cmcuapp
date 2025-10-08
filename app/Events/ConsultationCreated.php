<?php

namespace App\Events;

use App\Models\Consultation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConsultationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $consultation;

    /**
     * Create a new event instance.
     */
    public function __construct(Consultation $consultation)
    {
        $this->consultation = $consultation->load(['patient:id,nom,prenom', 'user:id,name']);
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('hospital.consultations'),
            new PrivateChannel('patient.' . $this->consultation->patient_id),
            new PrivateChannel('user.' . $this->consultation->user_id),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'consultation' => [
                'id' => $this->consultation->id,
                'patient_id' => $this->consultation->patient_id,
                'user_id' => $this->consultation->user_id,
                'description' => $this->consultation->description,
                'created_at' => $this->consultation->created_at->toISOString(),
            ],
            'patient' => [
                'id' => $this->consultation->patient->id,
                'name' => $this->consultation->patient->nom . ' ' . $this->consultation->patient->prenom,
            ],
            'doctor' => [
                'id' => $this->consultation->user->id,
                'name' => $this->consultation->user->name,
            ],
            'timestamp' => now()->toISOString(),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'consultation.created';
    }
}
