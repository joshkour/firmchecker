<?php

namespace App\Facades;

use App\Services\Interfaces\CacheInterface;
use App\Services\CacheKeyService;
use App\Services\UserEventService;
use App\Traits\Date;

/**
 * DashboardFacade class.
 *
 * Facade for retrieving data for dashboard from cache or database, saving to cache and any other related funtionalities.
 *
 * @author Josh Kour <josh.kour@gmail.com>
 */
class DashboardFacade
{
    use Date;

    private $cache;
    private $cacheKeyService;
    private $userEventService;

	/**
     * Class constructor.
     *
     * @param CacheInterface $cache
     * @param CacheKeyService $cacheKeyService
     * @param UserEventService $userEventService
     * @return void
     */
	public function __construct(
        CacheInterface $cache,
        CacheKeyService $cacheKeyService,
        UserEventService $userEventService
    ) {   
        $this->cache = $cache;
        $this->cacheKeyService = $cacheKeyService;
        $this->userEventService = $userEventService;
    }

    /**
     * Get metrics for dashboard.
     *
     * @param int $userId
     * @return array
     */
    public function getDashboardMetrics() : array 
    {
        $dashboardMetrics = [];
        $user = Auth::user();

        // The events we want to see metrics on
        $eventTypeIds = [EVENT_TYPE_REVIEWED, EVENT_TYPE_THUMBS_UP, EVENT_TYPE_THUMBS_DOWN];

        // Events data from one week ago
        $fromDate = $this->dateWeekAgo();

        // Try and fetch events from cache
        $userEventsCacheKey = $this->cacheKeyService->generateKeyUserEvents($eventTypeIds, $fromDate);
        $userEvents = $this->cache->get($userEventsCacheKey);
        if (empty($userEvents)) {
            // No cache data exist, fetch from DB
            $userEvents = $this->userEventService->getDashboardEvents($eventTypeIds, $fromDate);

            // Save data to cache
            $this->cache->save($userEventsCacheKey, $userEvents);
        }

        // Other dashboard data can be attached below

        return $dashboardMetrics;
    }
}