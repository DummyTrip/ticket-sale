<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use phpDocumentor\Reflection\Types\Array_;
use PhpParser\Node\Scalar\String_;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function venues()
    {
        return $this->hasMany('App\Venue', 'manager_id');
    }

    public function events()
    {
        return $this->hasMany('App\Event', 'organizer_id');
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    /**
     * Check if user has the role.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role)
    {
        $user = \Auth::user();

        $roles = $user->roles()->get();

        foreach ($roles as $user_role)
        {
            if ($user_role[$role])
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Add roles to a user.
     *
     * @param array $roles
     * @param User $user
     */
    public function addRole(array $roles, User $user)
    {
        $role_ids = array();

        foreach ($roles as $role)
        {
            if ($role !== '')
            {
                $role_ids[] = Role::where($role, true)->firstOrFail()->id;
            }
        }

        $user->roles()->sync($role_ids);

    }
}
