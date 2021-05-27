<?php

namespace App\Traits;

/**
 * Date trait.
 *
 * Custom date trait to help with date related requirements.
 *
 * @author Josh Kour <josh.kour@gmail.com>
 */
trait Date 
{
	/**
     * Get today's date.
     *
     * @param void
     * @return string
     */
    public function dateToday() : string {
        return date('Y-m-d');
    }

    /**
     * Get last week date relative to today's date.
     *
     * @param void
     * @return string
     */
    public function dateWeekAgo() : string{
        $weekAgo = strtotime('-1 week');
        $weekAgoDate = date('Y-m-d', $weekAgo);
        return $weekAgoDate;
    }
}