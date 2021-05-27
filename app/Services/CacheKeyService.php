<?php

namespace App\Services;

use Auth;

/**
 * CacheKeyService class.
 *
 * Service to provide management of cache keys.
 *
 * @author Josh Kour <josh.kour@gmail.com>
 */
class CacheKeyService
{
    /**
     * Generates role cache key.
     *
     * Use to create caching level dependent on current user role.
     *
     * @param void
     * @return string
     */
    protected function generateRoleKey() : string 
    {
        $key = '';

        $user = Auth::user();
        if ($user->hasRole(ROLE_ID_CLIENT)) {
            // Many client accounts under the same organisation will use the same cache (one cache for many users)
            $key .= 'cl_'.$user->organisation_id;
        } else if ($user->hasRole(ROLE_ID_USER)) {
            // Each user will have its own cache
            $key .= 'usr_'.$user->id;
        }

        return $key;
    }

    /**
     * Generates a full cache key.
     *
     * Key generation supporting granular data. i.e by event types and/or date
     *
     * @param array $eventTypeIds
     * @param string $fromDate
     * @param string $toDate
     * @return string
     */
    public function generateKeyUserEvents(array $eventTypeIds, string $fromDate = '', string $toDate = '') : string 
    {
        $key = 'userevents:';
        $key .= $this->generateRoleKey();

        return $key.':'.implode('_', $eventTypeIds).':'.$fromDate.':'.$toDate;
    }
}