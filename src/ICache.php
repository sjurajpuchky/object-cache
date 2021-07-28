<?php


namespace BABA\Cache;


interface ICache
{
    public function store($key, $object);
    public function load($key);
    public function isValid($key);
}