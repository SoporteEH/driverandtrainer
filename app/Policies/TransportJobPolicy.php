<?php

namespace App\Policies;

use App\Models\TransportJob;
use App\Models\User;

class TransportJobPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TransportJob $job): bool
    {
        return $user->hasRole('admin') || $user->id === $job->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, TransportJob $job): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return $user->id === $job->user_id && $job->date->diffInDays(now()) < 10;
    }

    public function delete(User $user, TransportJob $job): bool
    {
        return $user->hasRole('admin');
    }
}
