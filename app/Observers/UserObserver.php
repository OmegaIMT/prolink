<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\WelcomeToProLink;

class UserObserver
{
    public function created(User $user): void
    {
        $user->notify(new WelcomeToProLink());
    }
}