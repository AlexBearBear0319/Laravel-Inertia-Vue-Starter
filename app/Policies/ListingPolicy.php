<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ListingPolicy
{
    // "before" for the admin user to do any controller without any limir stated below.
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function view(?User $user, Listing $listing): bool
    {
        return $listing->user->role !== 'suspended' && $listing->approved;
    }

    public function create(User $user): bool
    {
        return $user->role !== 'suspended';
    }

    public function modify(User $user, Listing $listing): bool
    {
        // Check if the user is suspended and if the listing belongs to the user
        return $listing->user->role !== 'suspended' && $user->id === $listing->user_id;
    }

    public function approve(User $user, Listing $listing)
    {
        return $user->isAdmin();
    }
}
