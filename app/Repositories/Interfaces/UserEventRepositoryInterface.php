<?php

namespace App\Services\Interfaces;

/**
 * UserEventRepositoryInterface interface.
 *
 * Interface for fetching user events data.
 *
 * @author Josh Kour <josh.kour@gmail.com>
 */
interface UserEventRepositoryInterface
{
	/**
     * Get all user events by type.
     *
     * @param int $eventTypeIds
     * @param string $fromDate
     * @param string $toDate
     * @return array
     */
    public function getAllEvents(array $eventTypeIds, string $fromDate = '', string $toDate = '') : array;

    /**
     * Get organisation user events by type.
     *
     * @param int $organisationId
     * @param int $eventTypeIds
     * @param string $fromDate
     * @param string $toDate
     * @return array
     */
    public function getOrganisationEvents(int $organisationId, array $eventTypeIds, string $fromDate = '', string $toDate = '') : array;

    /**
     * Get user events by type.
     *
     * @param int $userId
     * @param int $eventTypeIds
     * @param string $fromDate
     * @param string $toDate
     * @return array
     */
    public function getUserEvents(int $userId, array $eventTypeIds, string $fromDate = '', string $toDate = '') : array;
}