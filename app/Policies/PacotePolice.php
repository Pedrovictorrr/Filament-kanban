<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pacote;
use Illuminate\Auth\Access\HandlesAuthorization;

class PacotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPacote('pacote_access');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pacote  $Pacote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Pacote $Pacote)
    {
        return $user->hasPacote('pacote_show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPacote('pacote_create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pacote  $Pacote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Pacote $Pacote)
    {
        return $user->hasPacote('pacote_edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pacote  $Pacote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Pacote $Pacote)
    {
        return $user->hasPacote('pacote_delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pacote  $Pacote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->hasPacote('pacote_delete');
    }
}
