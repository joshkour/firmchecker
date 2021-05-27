<?php

namespace App\Models;

/**
 * User class.
 *
 * @author Josh Kour <josh.kour@gmail.com>
 */
class User extends Model
{
    /**
     * Check if user is an admin.
     *
     * @param int $roleId
     * @return bool
     */
    public function isAdminRole() : bool
    {
        if ($this->role_id === ROLE_ID_ADMIN) {
            return true;
        }

        return false;
    }

    /**
     * Check if user is a client.
     *
     * @param int $roleId
     * @return bool
     */
    public function isClientRole() : bool
    {
        if ($this->role_id === ROLE_ID_CLIENT) {
            return true;
        }

        return false;
    }

    /**
     * Check if it is a user.
     *
     * @param int $roleId
     * @return bool
     */
    public function isUserRole() : bool
    {
        if ($this->role_id === ROLE_ID_USER) {
            return true;
        }

        return false;
    }

    /**
     * Check if user has a given permission.
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission) : bool
    {
        // Get permissions that this user has
        $permissions = $this->permissions;
        foreach ($permissions as $permission) {
            if ($permission->system_name === $permission) {
                return true;
            }
        }
        return false;
    }
}