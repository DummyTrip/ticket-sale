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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function venues()
    {
        return $this->hasMany('App\Venue', 'manager_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany('App\Event', 'organizer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    /**
     * Get an array of user roles.
     *
     * @return array
     */
    public function getRoles()
    {
        $user_roles = $this->roles()->get();
        $roles = array('admin' => false, 'manager' => false, 'organizer' => false);

        foreach ($user_roles as $user_role)
        {
            foreach ($roles as $role_name => $role_value)
            {
                if ($user_role[$role_name])
                {
                    $role[$role_name] = true;
                }
            }
        }

        return $roles;
    }

    /**
     * Check if user has the role.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role)
    {
        $roles = $this->roles()->get();

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
     */
    public function addRole(array $roles)
    {
        $role_ids = array();

        foreach ($roles as $role)
        {
            if ($role !== '')
            {
                $role_ids[] = Role::where($role, true)->firstOrFail()->id;
            }
        }

        $this->roles()->sync($role_ids);

    }
}
