<?php
namespace Tests\Unit\Traits;

use PHPUnit\Framework\TestCase;
use App\Facades\DashboardFacade;

/**
 * Defines a class for Dashboard Facade methods.
 *
 * @group Unit
 */
final class DashboardFacadeTest extends TestCase
{
    /**
     * Dashboard facade under test.
     *
     * @var App\Facades\DashboardFacade
     */
    private $dashboardFacade;

    /**
     * {@inheritdoc}
     */
    public function setUp() 
    {
        $this->mockCache = $this->getMockBuilder('App\Services\RedisCache')
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        $this->mockCacheKeyService = $this->getMockBuilder('App\Services\CacheKeyService')
            ->disableOriginalConstructor()
            ->setMethods(['generateKeyUserEvents'])
            ->getMock();

        $this->mockUserEventRepository = $this->getMockBuilder('App\Repositories\UserEventRepository')
            ->disableOriginalConstructor()
            ->setMethods(['getEventsByTypes'])
            ->getMock();

        $this->dashboardFacade = new DashboardFacade(
            $this->mockCache,
            $this->mockCacheKeyService,
            $this->mockUserEventRepository
        );
    }

    /**
     * Test method getDashboardMetrics.
     *
     * Test case where both cache and database return empty results.
     */
    public function testGetDashboardMetricsEmpty() 
    {
        $userId = 1;
        $cacheKey = 'somecachekey';
        $cacheReturn = [];
        $dbReturn = [];

        $this->mockCacheKeyService->expects($this->once())
            ->method('generateKeyUserEvents')
            ->with($this->equalTo($userId), $this->isType('array'), $this->isType('string'))
            ->willReturn($cacheKey);

        $this->mockCache->expects($this->once())
            ->method('get')
            ->with($this->equalTo($cacheKey))
            ->willReturn($cacheReturn);

        $this->mockUserEventRepository->expects($this->once())
            ->method('getEventsByTypes')
            ->with($this->equalTo($userId), $this->isType('array'), $this->isType('string'))
            ->willReturn($dbReturn);

        $result = $this->dashboardFacade->getDashboardMetrics($userId);
        $this->assertEquals([], $result);
    }

    /**
     * Test method getDashboardMetrics.
     *
     * Test that a key is valid.
     */
    public function testGetDashboardMetricsCacheNotEmpty() 
    {
        $userId = 1;
        $cacheKey = 'somecachekey';
        $cacheReturn = 'somecachedata';

        $this->mockCacheKeyService->expects($this->once())
            ->method('generateKeyUserEvents')
            ->with($this->equalTo($userId), $this->isType('array'), $this->isType('string'))
            ->willReturn($cacheKey);

        $this->mockCache->expects($this->once())
            ->method('get')
            ->with($this->equalTo($cacheKey))
            ->willReturn($cacheReturn);

        $this->mockUserEventRepository->expects($this->never())
            ->method('getEventsByTypes');

        $result = $this->dashboardFacade->getDashboardMetrics($userId);
        $this->assertEquals($cacheReturn, $result);
    }
}
