<?php


namespace BABA\Cache;


use BABA\Cache\ICache;
use BABA\Cache\ICacheDriver;
use DateTime;
use stdClass;

class Cache implements ICache
{

    /**
     * @var array
     */
    private array $records = [];
    private ICacheDriver $driver;
    private $defaultTtl = 3600;

    /**
     * Cache constructor.
     * @param ICacheDriver $driver
     * @param int $defaultTtl
     */
    public function __construct(ICacheDriver $driver, $defaultTtl = 3600)
    {
        $this->driver = $driver;
        $this->defaultTtl = $defaultTtl;
    }


    private function prepareCacheObject($key, $object, $ttl = false)
    {
        if(!$ttl) {
            $ttl = $this->defaultTtl;
        }

        $cacheObj = new stdClass();
        $cacheObj->updated = (new DateTime())->getTimestamp();
        $cacheObj->object = $object;
        $cacheObj->ttl = $ttl;
        $cacheObj->key = $key;

        return $cacheObj;
    }

    /**
     * @param $key
     * @return bool
     */
    public function isValid($key): bool
    {
        if (!isset($this->records[$key])) {
            $cacheObj = $this->driver->load($key);
            $this->records[$key] = $cacheObj;
        } else {
            $cacheObj = $this->records[$key];
        }
        return !is_null($cacheObj) ? (($cacheObj->ttl + $cacheObj->updated) > (new DateTime())->getTimestamp()) : false;
    }

    public function store($key, $object)
    {
        $cacheObj = $this->prepareCacheObject($key, $object);
        $this->records[$key] = $cacheObj;
        $this->driver->store($key, $cacheObj);
    }

    public function load($key)
    {
        if(!isset($this->records[$key])) {
            $cacheObj = $this->driver->load($key);
            $this->records[$key] = $cacheObj;
        } else {
            $cacheObj = $this->records[$key];
        }
        return $cacheObj ? $cacheObj->object : false;
    }
}