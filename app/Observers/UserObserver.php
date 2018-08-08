<?php

namespace App\Observers;


use App\Models\User;

class UserObserver
{

    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        $user->firm()->create([
            'name' => $user->name,
            'slug' => str_slug($user->name) . str_random(10)
        ]);
    }
}
