<?php

namespace App\Observers;

use App\Models\Company;
use App\Models\Profile;
use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        if ($user->role === 'company') {
            Company::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'city' => 'Non spécifié',
            ]);
        } else {
            Profile::create([
                'user_id' => $user->id,
            ]);
        }
    }
}