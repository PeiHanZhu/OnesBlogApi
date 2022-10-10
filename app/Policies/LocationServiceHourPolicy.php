<?php

namespace App\Policies;

use App\Models\Location;
use App\Models\LocationServiceHour;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationServiceHourPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LocationServiceHour  $locationServiceHour
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, LocationServiceHour $locationServiceHour)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param Location $location
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Location $location)
    {
        return intval($user->id) === intval($location->user_id);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LocationServiceHour  $locationServiceHour
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, LocationServiceHour $locationServiceHour)
    {
        return !is_null($location = $user->location) and intval($location->id) === intval($locationServiceHour->location_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LocationServiceHour  $locationServiceHour
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, LocationServiceHour $locationServiceHour)
    {
        return !is_null($location = $user->location) and intval($location->id) === intval($locationServiceHour->location_id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LocationServiceHour  $locationServiceHour
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, LocationServiceHour $locationServiceHour)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LocationServiceHour  $locationServiceHour
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, LocationServiceHour $locationServiceHour)
    {
        //
    }
}
