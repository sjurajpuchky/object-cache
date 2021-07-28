<?php


namespace BABA\Cache;


interface ICacheDriver
{
    public function __construct($params);
    /**
     * @param $key
     * @param $jung
     * @return bool
     */
    public function store($key,$jung): bool;

    /**
     * @param $key
     * @return object|null
     */
    public function load($key): ?object;

}