<?php


namespace BABA\Cache\Drivers;


use BABA\Cache\CacheDriver;
use BABA\Cache\ICacheDriver;

class Redis extends CacheDriver implements ICacheDriver
{
    /** @var Redis */
    private $connection;
    /** @var array  */
    protected $DEFAULTS = [
        'host' => '127.0.0.1',
        'port' => 6379,
        'sock' => ''
    ];

    /**
     * Disk constructor.
     * @param $params
     */
    public function __construct($params= [])
    {
        if (!class_exists('Redis')) {
            throw new Exception('Extension php-redis is not supported');
        }

        $this->prepareConfig($params);
        $this->connection = new \Redis();

        if(!empty($this->config['sock'])) {
            $this->connection->connect($this->config['sock']);
        } else {
            $this->connection->connect($this->config['host'], $this->config['port']);
        }
    }


    /**
     * @param $key
     * @param $object
     * @return bool
     */
    public function store($key, $object): bool
    {
        return $this->connection->set($key, json_encode($object));
    }

    /**
     * @param $key
     * @return object|null
     */
    public function load($key): ?object
    {
        $f = $this->connection->get($key);
        return $f ? json_decode($f) : NULL;
    }
}