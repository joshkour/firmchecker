<?php

namespace App\Services;

use App\Services\Interfaces\UserEventRepositoryInterface;

/**
 * UserEventRepository class.
 *
 * @author Josh Kour <josh.kour@gmail.com>
 */
class UserEventRepository implements UserEventRepositoryInterface
{
	/**
     * Class constructor.
     *
     * @param DbInterface $cache
     * @param CacheInterface $cache
     * @return void
     */
	public function __construct(DbInterface $db) 
	{
        $this->db = $db;
    }

    /**
     * Get all user events by type.
     *
     * @param int $eventTypeIds
     * @param string $fromDate
     * @param string $toDate
     * @return array
     */
    public function getAllEvents(array $eventTypeIds, string $fromDate = '', string $toDate = '') : array 
    {
        // Retrieve data from DB (i.e if Laravel framework is used, make use of Eloquent to retrieve the data)
        return $this->db->getAllEventsQuery();
    }

    /**
     * Get organisation user events by type.
     *
     * @param int $organisationId
     * @param int $eventTypeIds
     * @param string $fromDate
     * @param string $toDate
     * @return array
     */
    public function getOrganisationEvents(int $organisationId, array $eventTypeIds, string $fromDate = '', string $toDate = '') : array 
    {
        // Retrieve data from DB (i.e if Laravel framework is used, make use of Eloquent to retrieve the data)
        return $this->db->getOrganisationEventsQuery();
    }

    /**
     * Get user events by type.
     *
     * @param int $userId
     * @param int $eventTypeIds
     * @param string $fromDate
     * @param string $toDate
     * @return array
     */
    public function getUserEvents(int $userId, array $eventTypeIds, string $fromDate = '', string $toDate = '') : array 
    {
        // Retrieve data from DB (i.e if Laravel framework is used, make use of Eloquent to retrieve the data)
        return $this->db->getUserEventsQuery();
    }
}