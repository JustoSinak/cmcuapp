<?php

namespace App\Policies;

use App\User;
use App\FactureConsultation;
use Illuminate\Auth\Access\HandlesAuthorization;

class FactureConsultationPolicy
{
    use HandlesAuthorization;

    
    public function update(User $user, FactureConsultation $factureConsultation)
    {
        return in_array(auth()->user()->role_id, [
            1,6
        ]);
    }

   
}
