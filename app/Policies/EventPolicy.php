<?php

namespace App\Policies;

use App\User;
use App\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;


    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {

            return true;
        }
    }

    public function view(User $user)
    {
        return true;
    }


    public function create(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,6
        ]);
    }


    public function update(User $user, Event $event)
    {
        return in_array(auth()->user()->role_id, [
            1,6
        ]);
    }


    public function delete(User $user, Event $event)
    {
        return in_array(auth()->user()->role_id, [
            1,6
        ]);
    }


    public function restore(User $user, Event $event)
    {
        //
    }


    public function forceDelete(User $user, Event $event)
    {
        //
    }
}
