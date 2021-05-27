<?php

namespace App\Services;

use App\Repositories\Interfaces\UserEventRepositoryInterface;

/**
 * UserEventService class.
 *
 * Service class that provides functionalities around User Events.
 *
 * @author Josh Kour <josh.kour@gmail.com>
 */
class UserEventService
{
    /**
     * Class constructor.
     *
     * @param UserEventRepositoryInterface $userEventRepository
     * @return void
     */
    public function __construct(
        UserEventRepositoryInterface $userEventRepository
    ) {
        $this->userEventRepository = $userEventRepository;
    }

	/**
     * Get events for dashboard.
     *
     * Events returned will be based on current user role
     *
     * @param array $eventTypeIds
     * @param string $fromDate
     * @param string $toDate
     * @return array
     */
	public function getDashboardEvents(array $eventTypeIds = [], string $fromDate = '', string $toDate = '') : array
	{
        $userEvents = [];

        $user = Auth::user();
        if ($user->isClientRole()) {
            $userEvents = $this->userEventRepository->getOrganisationEvents($user->id, $eventTypeIds, $fromDate, $toDate);
        } else if ($user->isUserRole()) {
            $userEvents = $this->userEventRepository->getUserEvents($user->organisation_id, $eventTypeIds, $fromDate, $toDate);
        } else {
            $userEvents = $this->userEventRepository->getAllEvents($eventTypeIds, $fromDate, $toDate);
        }

        return $userEvents;
	}