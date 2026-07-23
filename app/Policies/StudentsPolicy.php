<?php

namespace App\Policies;

use App\Models\Students;
use App\Models\Users;
use Illuminate\Auth\Access\Response;

class StudentsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Users $users): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Users $users, Students $student): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Users $users): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Users $users, Students $student): bool
    {
        // return true;
        return in_array($users->role->slug, [
            'staff',
            'admin',
            'super-admin',
        ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Users $users, Students $student): bool
    {
        // return false;
        return in_array($users->role->slug, [
            'admin',
            'super-admin',
        ]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Users $users, Students $student): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Users $users, Students $student): bool
    {
        return false;
    }
}
