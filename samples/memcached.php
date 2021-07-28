<?php
require_once __DIR__.'/../vendor/autoload.php';

$object = [1,2,3,4];

$cache = new \BABA\Cache\Cache(new \BABA\Cache\Drivers\Memcached());

$cache->store('test', $object);
var_dump($cache->load('test'));