<?php

namespace App\Policies;

use App\Devis;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Devisdpolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdmin() && $user->isCaisse() && $user->isMedecin() && $user->isLogistique()) {

            return true;
        }
    }


    public function view(User $user, Devis $devis)
    {
        return true;
    }

    public function create(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,2,6,5
        ]);
    }


    public function update(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,2,6,5
        ]);
    }

    public function print(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,2,6,5
        ]);

    }

    public function print_devis(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,2,6,5
        ]);

    }

    public function delete(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1
        ]);

    }

    public function consulter()
    {
        return in_array(auth()->user()->role_id, [
            1,2,6,5
        ]);

    }

}
