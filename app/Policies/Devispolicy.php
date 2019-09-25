<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Devispolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {

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
            1,2,6,3
        ]);
    }


    public function update(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,2,6,3
        ]);
    }

    public function print(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,2,6,3
        ]);

    }

    public function print_devis(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,2,6,3
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
            1,2,6,3
        ]);

    }
}
