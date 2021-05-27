<?php

namespace App\Services;

use App\Services\Interfaces\CacheInterface;

/**
 * RedisCache class.
 *
 * Redis cache class to handle retrieval and saving of data to redis to support caching mechanism.
 *
 * @author Josh Kour <josh.kour@gmail.com>
 */
class RedisCache implements CacheInterface
{
	/**
     * Get cache data for a given key.
     *
     * @param string $key
     */
	public function get(string $key)
	{
        return json_decode($this->get($key));
	}

	/**
     * Save data into cache for a given key and value pair.
     *
     * @param string $key
     * @param $value
     * @return bool
     */
    public function save(string $key, $value) : bool 
    {
    	return $this->save($key, json_encode($value));
    }
}