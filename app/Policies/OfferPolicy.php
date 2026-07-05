<?php

namespace App\Policies;

use App\Models\Offer;
use App\Models\User;

class OfferPolicy
{
    public function update(User $user, Offer $offer): bool
    {
        return $user->company && $user->company->id === $offer->company_id;
    }

    public function delete(User $user, Offer $offer): bool
    {
        return $user->company && $user->company->id === $offer->company_id;
    }
}